<?php

class Usuario
{
    private $identificacion;
    private $tipoId;
    private $nombre1;
    private $nombre2;
    private $apellido1;
    private $apellido2;
    private $telefono;
    private $email;

    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;
    }

    public function setTipoId($tipoId)
    {
        $this->tipoId = $tipoId;
    }

    public function setNombre1($nombre1)
    {
        $this->nombre1 = $nombre1;
    }

    public function setNombre2($nombre2)
    {
        $this->nombre2 = $nombre2;
    }

    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }

    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function GETusuarios($conexion, $id)
    {
        $sql = ($id === null) ? "SELECT*FROM usuarios WHERE activo = 1" : "SELECT*FROM usuarios WHERE id = $id AND activo = 1";
        $usuarios = array();
        $resultado = $conexion->query($sql);

        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }
            $resultado->free();
        }
        return $usuarios;
    }

    public function registrarse($conexion, $clave)
{
    $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);
    $conexion->begin_transaction();
    $enviado = true;

    if ($enviado) {
        $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, activo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("ssssssss", $this->identificacion, $this->tipoId, $this->nombre1, $this->nombre2, $this->apellido1, $this->apellido2, $this->telefono, $this->email);

        if ($bin->execute()) {
            $token = bin2hex(random_bytes(16));
            $id_aut = $conexion->insert_id;
            $sql2 = "INSERT INTO credenciales (id, email, token, codigo, fecha_cambio, password) VALUES (?, ?, ?, ?, NOW(), ?)";
            $bin2 = $conexion->prepare($sql2);
            $codigo = rand(1000, 9999);
            $bin2->bind_param("sssss", $id_aut, $this->email, $token, $codigo, $hashedPassword);

            if ($bin2->execute()) {
                $conexion->commit();
                return ["success" => true, "mensaje" => "Registrado"];
            } else {
                $conexion->rollback();
                return ["success" => false, "mensaje" => "Error al registrar la credencial: " . $bin2->error];
            }
        } else {
            $conexion->rollback();
            return ["success" => false, "mensaje" => "Error al registrar el usuario: " . $bin->error];
        }
    } else {
        return ["success" => false, "mensaje" => "Error al verificar correo"];
    }
}

    public function Login($conexion, $contraseña)
    {
        $email = $this->email;
        $query = "SELECT u.id,u.primerNombre,u.primerApellido,u.email,cr.password FROM usuarios as u
        LEFT JOIN credenciales as cr ON u.id = cr.id
        WHERE u.activo = 1 and u.email = '$email'";
        $result = $conexion->query($query);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($contraseña, $hashedPassword)) {
                    $response = [
                        "accesso" => true,
                        "mensaje" => "Verificado correctamente",
                        "usuario" => [
                            "id" => $row['id'],
                            "nombre" => $row['primerNombre'],
                            "apellido" => $row['primerApellido'],
                            "email" => $row['email']
                        ]
                    ];
                    return $response;
                } else {
                    return ["accesso" => false, "mensaje" => "Contraseña incorrecta: $conexion->error"];
                }
            } else {
                return ["accesso" => false, "mensaje" => "usuario no encontrado: $conexion->error"];
            }
        } else {
            return ["accesso" => false, "mensaje" => 'Error en la cosulta = ' . $conexion->error . ''];
        }
    }

    public function verDatos($conexion, $id)
    {
        $sql = "SELECT*FROM usuarios WHERE id = '$id'";
        $con = $conexion->query($sql);
        if ($con->num_rows > 0) {
            $row = $con->fetch_assoc();
            $_SESSION['iduser'] = $row['id'];
            $_SESSION['identificacion'] = $row['identificacion'];
            $_SESSION['tipoid'] = $row['tipoId'];
            $_SESSION['nombre1'] = $row['primerNombre'];
            $_SESSION['nombre2'] = $row['segundoNombre'];
            $_SESSION['apellido1'] = $row['primerApellido'];
            $_SESSION['apellido2'] = $row['segundoApellido'];
            $_SESSION['telefono'] = $row['telefono'];
            $_SESSION['email'] = $row['email'];
        }
    }

    public function actualizarDatos($conexion)
    {
        $sql = "UPDATE usuarios SET primerNombre = ?,segundoNombre = ?, primerApellido = ?, segundoApellido = ?,telefono = ?, email = ? WHERE identificacion = ?";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("sssssss", $this->nombre1, $this->nombre2, $this->apellido1, $this->apellido2, $this->telefono, $this->email, $this->identificacion);
        $bin->execute();
    }

    public function cambiarClave($id, $passwordactual, $passwordnueva, $passwordnueva2)
    {
        global $conexion;
        if ($passwordnueva != $passwordnueva2) {
            return ['encontrado' => false, 'mensaje' => 'Las contraseñas no coinciden'];
        }
        $query = "SELECT password FROM credenciales WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sqlverificar = "SELECT * FROM credenciales WHERE id = ? AND TIMESTAMPDIFF(DAY, fecha_cambio, NOW()) > 30";
            $binver = $conexion->prepare($sqlverificar);
            $binver->bind_param("s", $id);
            $binver->execute();
            $result2 = $binver->get_result();
            if ($result2->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($passwordactual, $hashedPassword)) {
                    $token = bin2hex(random_bytes(16));
                    $hashedNuevaPassword = password_hash($passwordnueva, PASSWORD_BCRYPT);
                    $sql = "UPDATE credenciales SET password = ?,token = ?, fecha_cambio = NOW() WHERE id = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("sss", $hashedNuevaPassword, $token, $id);
                    $stmt->execute();
                    return ['encontrado' => true, 'mensaje' => 'Clave actualizada'];
                } else {
                    echo $conexion->error;
                    return ['encontrado' => false, 'mensaje' => 'La contraseña actual no coincide, asegurate de que sea la correcta'];
                }
            } else {
                return ['encontrado' => false, 'mensaje' => 'La contraseña solo se puede cambiar luego de 30 dias del ultimo cambio'];
            }
        } else {
            echo "Usuario no encontrado";
            return ['encontrado' => false, 'mensaje' => 'Usuario no encontrado'];
        }
        $stmt->close();
    }

    public function VerificarExistencia($id)
    {
    }
    public function verificarToken($conexion, $idusuario, $token_ingresado)
    {
        $token_db = null;
        $id = null;
        $sql = "SELECT id, token FROM credenciales WHERE id = ? AND activo = 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('s', $idusuario);
        $stmt->execute();
        $stmt->bind_result($id, $token_db);
        $stmt->fetch();
        $stmt->close();
        

        if ($token_db && hash_equals($token_db, $token_ingresado)) {
            return true;
        } else {
            return false;
        }
    }

    public function resetPassword($conexion) {
        $email = $this->email;
        $sql = "SELECT * FROM credenciales WHERE email = ?";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("s", $email);
        $bin->execute();
        $result = $bin->get_result();
        $token = bin2hex(random_bytes(16));
        
        if ($result->num_rows > 0) {
            include 'mailrestart.php';            
            if ($enviado) {
                $sql2 = "UPDATE credenciales SET token = ?, codigo = ?, fecha_cambio = NOW() WHERE email = ?";
                $bin2 = $conexion->prepare($sql2);
                $bin2->bind_param("sss", $token, $codigo, $email);
                
                if ($bin2->execute()) {
                    return ['status'=>true, "mensaje"=>"Enviado"]; 
                } else {
                    return ['status'=>false, "mensaje"=>"No ejecutado"]; 
                }
            } else {
                return ['status'=>false, "mensaje"=>"Correo no enviado"]; 
            }
        } else {
            return ['status'=>false, "mensaje"=>"Correo no existe"]; 
        }
    }
    
    
    
    
}
