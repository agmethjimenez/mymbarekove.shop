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

    public function GETusuarios($conexion, $id) {
        try {
            if ($id === null) {
                $sql = "SELECT * FROM usuarios WHERE activo = 1";
                $stmt = $conexion->prepare($sql);
            } else {
                $sql = "SELECT * FROM usuarios WHERE id = :id AND activo = 1";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }
    
            $stmt->execute();
    
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $stmt->closeCursor();
    
            return $usuarios;
        } catch(PDOException $e) {
            echo "Error al obtener usuarios: " . $e->getMessage();
            return array(); 
        }
    }


    public function registrarse($conexion, $clave) {
    try {
        // Hash de la contraseña
        $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

        $conexion->beginTransaction();

        $enviado = true;

        if ($enviado) {
            $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, activo)
                    VALUES (:identificacion, :tipoId, :primerNombre, :segundoNombre, :primerApellido, :segundoApellido, :telefono, :email, 1)";
            $stmt = $conexion->prepare($sql);

            $stmt->bindParam(':identificacion', $this->identificacion);
            $stmt->bindParam(':tipoId', $this->tipoId);
            $stmt->bindParam(':primerNombre', $this->nombre1);
            $stmt->bindParam(':segundoNombre', $this->nombre2);
            $stmt->bindParam(':primerApellido', $this->apellido1);
            $stmt->bindParam(':segundoApellido', $this->apellido2);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':email', $this->email);

            if ($stmt->execute()) {
                $token = bin2hex(random_bytes(16));
                $codigo = rand(1000, 9999);

                $id_aut = $conexion->lastInsertId();

                $sql2 = "INSERT INTO credenciales (id, email, token, codigo, fecha_cambio, password)
                        VALUES (:id, :email, :token, :codigo, NULL, :password)";
                $stmt2 = $conexion->prepare($sql2);

                $stmt2->bindParam(':id', $id_aut);
                $stmt2->bindParam(':email', $this->email);
                $stmt2->bindParam(':token', $token);
                $stmt2->bindParam(':codigo', $codigo);
                $stmt2->bindParam(':password', $hashedPassword);

                if ($stmt2->execute()) {
                    $conexion->commit();
                    return ["status" => true, "mensaje" => "Registrado"];
                } else {
                    $conexion->rollBack();
                    return ["status" => false, "mensaje" => "Error al registrar la credencial"];
                }
            } else {
                $conexion->rollBack();
                return ["status" => false, "mensaje" => "Error al registrar el usuario"];
            }
        } else {
            return ["status" => false, "mensaje" => "Error al verificar correo"];
        }
    } catch(PDOException $e) {
        $conexion->rollBack();
        return ["status" => false, "mensaje" => "Error en la transacción: " . $e->getMessage()];
    }
}

    


public function Login($conexion, $contraseña) {
    try {
        $email = $this->email;

        $sql = "SELECT u.id, u.primerNombre, u.primerApellido, u.email, cr.password 
                FROM usuarios AS u
                LEFT JOIN credenciales AS cr ON u.id = cr.id
                WHERE u.activo = 1 AND u.email = :email";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $hashedPassword = $row['password'];

            if (password_verify($contraseña, $hashedPassword)) {
                $response = [
                    "status" => true,
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
                return ["status" => false, "mensaje" => "Contraseña incorrecta"];
            }
        } else {
            return ["status" => false, "mensaje" => "Usuario no encontrado"];
        }
    } catch(PDOException $e) {
        return ["status" => false, "mensaje" => "Error en la consulta: " . $e->getMessage()];
    }
}


public function verDatos($conexion, $id)
{
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $statement = $conexion->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT); 
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC); 
    if ($result !== false) {
        $_SESSION['iduser'] = $result['id'];
        $_SESSION['identificacion'] = $result['identificacion'];
        $_SESSION['tipoid'] = $result['tipoId'];
        $_SESSION['nombre1'] = $result['primerNombre'];
        $_SESSION['nombre2'] = $result['segundoNombre'];
        $_SESSION['apellido1'] = $result['primerApellido'];
        $_SESSION['apellido2'] = $result['segundoApellido'];
        $_SESSION['telefono'] = $result['telefono'];
        $_SESSION['email'] = $result['email'];
    }
}

    public function actualizarDatos($conexion) {
        try {
            $sql = "UPDATE usuarios SET primerNombre = :primerNombre, segundoNombre = :segundoNombre, primerApellido = :primerApellido, segundoApellido = :segundoApellido, telefono = :telefono, email = :email WHERE identificacion = :identificacion AND ACTIVO = true";
            $stmt = $conexion->prepare($sql);
    
            $stmt->bindParam(':primerNombre', $this->nombre1);
            $stmt->bindParam(':segundoNombre', $this->nombre2);
            $stmt->bindParam(':primerApellido', $this->apellido1);
            $stmt->bindParam(':segundoApellido', $this->apellido2);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':identificacion', $this->identificacion);
    
            $stmt->execute();
    
            $stmt->closeCursor();
        } catch(PDOException $e) {
            echo "Error al actualizar datos: " . $e->getMessage();
        }
    }

    public function cambiarClave($conexion, $id, $passwordactual, $passwordnueva, $passwordnueva2) {
        try {
            if ($passwordnueva != $passwordnueva2) {
                return ['encontrado' => false, 'mensaje' => 'Las contraseñas no coinciden'];
            }
    
            $sql = "SELECT password FROM credenciales WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                $hashedPassword = $row['password'];
    
                if (password_verify($passwordactual, $hashedPassword)) {
                        $token = bin2hex(random_bytes(16));
                        $hashedNuevaPassword = password_hash($passwordnueva, PASSWORD_BCRYPT);
    
                        $sqlUpdate = "UPDATE credenciales SET password = :password, token = :token, fecha_cambio = NOW() WHERE id = :id";
                        $stmtUpdate = $conexion->prepare($sqlUpdate);
                        $stmtUpdate->bindParam(':password', $hashedNuevaPassword);
                        $stmtUpdate->bindParam(':token', $token);
                        $stmtUpdate->bindParam(':id', $id);
                        $stmtUpdate->execute();
                        return ['encontrado' => true, 'mensaje' => 'Clave actualizada'];
            
                } else {
                    return ['encontrado' => false, 'mensaje' => 'La contraseña actual no coincide, asegúrate de que sea la correcta'];
                }
            } else {
                return ['encontrado' => false, 'mensaje' => 'Usuario no encontrado'];
            }
        } catch(PDOException $e) {
            echo "Error al cambiar la clave: " . $e->getMessage();
        }
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
        $sql = "SELECT * FROM credenciales WHERE email = :email";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $token = bin2hex(random_bytes(16));           
            include 'mailrestart.php';
            
            if ($enviado) {
                $sqlUpdate = "UPDATE credenciales SET token = :token, codigo = :codigo, fecha_cambio = NOW() WHERE email = :email";
                $stmtUpdate = $conexion->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':token', $token, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':email', $email, PDO::PARAM_STR);
                
                if ($stmtUpdate->execute()) {
                    return ['status' => true, 'mensaje' => 'Enviado']; 
                } else {
                    return ['status' => false, 'mensaje' => 'No ejecutado']; 
                }
            } else {
                return ['status' => false, 'mensaje' => 'Correo no enviado']; 
            }
        } else {
            return ['status' => false, 'mensaje' => 'Correo no existe']; 
        }
    }
    

    public function VerificarExistenciayCaducidad($conexion, $token, $codigo){
        $email = $this->email;
        $sql = "SELECT email, token, codigo FROM credenciales WHERE email = :email AND token = :token AND codigo = :codigo";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":token",$token);
        $stmt->bindParam(":codigo",$codigo);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result !== false){
            $sql2 = "SELECT * FROM credenciales WHERE email = :email AND token = :token AND codigo = :codigo AND TIMESTAMPDIFF(MINUTE, fecha_cambio, NOW()) < 30";
            $stmt2 = $conexion->prepare($sql2);
            $stmt2->bindParam(":email",$email);
            $stmt2->bindParam(":token",$token);
            $stmt2->bindParam(":codigo",$codigo);
            $stmt2->execute();

            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if($result2 !== false){
                return[
                    "status"=>true
                ];
            }else{
                return[
                    "status"=>false,
                    "error"=>"Codigo caducado."
                ];
            }
        }else{
            return[
                "status"=>false,
                "error"=>"Usuario no encontrado."
            ];
        }
    }

    public function actualizarCredenciales($conexion,$password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        $token = bin2hex(random_bytes(16));
        $email = $this->email;
    
        try {
            $sql = "UPDATE credenciales SET password = :password, token = :token WHERE email = :email";
            $stmt = $conexion->prepare($sql);
    
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":token", $token);
            $stmt->bindParam(":email", $email);
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
           
            return false; 
        }
    }
    
    
    
    
}
