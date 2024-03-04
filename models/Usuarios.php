<?php
require '../vendor/autoload.php';
require_once("../database/conexion.php");
$database = new Database();
$conexion = $database->connect();

class Usuario
{

    public function registrarse($id_usuario, $tipoid, $name1, $name2, $lastname1, $lastname2, $telefono, $email, $clave)
{
    $hashedPassword = password_hash($clave, PASSWORD_BCRYPT);
    global $conexion;

    $conexion->begin_transaction();
    $enviado = true;

    if ($enviado) {
        $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, activo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("ssssssss", $id_usuario, $tipoid, $name1, $name2, $lastname1, $lastname2, $telefono, $email);

        if ($bin->execute()) {
            $token = bin2hex(random_bytes(16));
            $id_aut = $conexion->insert_id;
            $sql2 = "INSERT INTO credenciales (id, email, token, codigo, fecha_cambio, password) VALUES (?, ?, ?, ?, NOW(), ?)";
            $bin2 = $conexion->prepare($sql2);
            $codigo = rand(1000,9999); // ¡Asegúrate de tener un valor adecuado para $codigo!
            $bin2->bind_param("sssss", $id_aut, $email, $token, $codigo, $hashedPassword);

            if ($bin2->execute()) {
                $conexion->commit();
                return ["success" => true, "mensaje" => "Registrado"];
            } else {
                $conexion->rollback();
                return ["success" => false, "mensaje" => "Error al registrar"];
            }

        } else {
            $conexion->rollback();
            return ["success" => false, "mensaje" => "Error al registrar el usuario: " . $conexion->error];
        }
    } else {
        return ["success" => false, "mensaje" => "Error al verificar correo"];
    }
}

public function Login($correo, $contraseña){
    global $conexion;
        $error_message = " ";
        $query = "SELECT u.id,u.primerNombre,u.primerApellido,u.email,cr.password FROM usuarios as u
        LEFT JOIN credenciales as cr ON u.id = cr.id
        WHERE u.activo = 1 and u.email = '$correo'";
        $result = $conexion->query($query);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($contraseña, $hashedPassword)) {
                    /*$_SESSION['id_usuario'] = $row['id'];
                    $_SESSION['usuario_nombre'] = $row['primerNombre'];
                    $_SESSION['usuario_apellido'] = $row['primerApellido'];*/
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
                    return["accesso" => false, "mensaje" => "Contraseña incorrecta"];

                }
            } else {  
                return["accesso" => false, "mensaje" => "usuario no encontrado"];

            }
        } else {
            return["accesso" => false, "mensaje" => 'Error en la cosulta = '.$conexion->error.''];

        }

}

    

    public function inicioSesion($correo, $contraseña)
    {
        global $conexion;
        $error_message = " ";
        $query = "SELECT u.id,u.primerNombre,u.primerApellido,u.email,cr.password FROM usuarios as u
        LEFT JOIN credenciales as cr ON u.id = cr.id
        WHERE u.activo = 1 and u.email = '$correo'";
        $result = $conexion->query($query);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($contraseña, $hashedPassword)) {
                    $_SESSION['id_usuario'] = $row['id'];
                    $_SESSION['usuario_nombre'] = $row['primerNombre'];
                    $_SESSION['usuario_apellido'] = $row['primerApellido'];
                    header("location: catalogo.php");
                    exit();
                } else {          
                    echo '<div class="message is-danger" id="message">';
                    echo '<p>Contraseña incorrecta</p>';
                    echo '</div>';
                }
            } else {  
                echo '<div class="message is-danger" id="message">';
                echo '<p>Usuario no encontrado</p>';
                echo '</div>';
            }
        } else {
            $error_message = "Error en la consulta: " . $conexion->error;
        }
    }

    public function verDatos($id){
        global $conexion;

        $sql = "SELECT*FROM usuarios WHERE id = '$id'";
        $con = $conexion->query($sql);
        if($con->num_rows>0){
            $row=$con->fetch_assoc();
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

    public function actualizarDatos($id,$nombre1,$nombre2,$apellido1,$apellido2,$telefono,$email){
        global $conexion;
        $sql = "UPDATE usuarios SET primerNombre = ?,segundoNombre = ?, primerApellido = ?, segundoApellido = ?,telefono = ?, email = ? WHERE identificacion = ?";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("sssssss",$nombre1,$nombre2,$apellido1,$apellido2,$telefono,$email,$id);
        $bin->execute();
    }

    
    public function cambiarClave($id, $passwordactual, $passwordnueva, $passwordnueva2) {
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
                $stmt->bind_param("sss", $hashedNuevaPassword,$token, $id);
                $stmt->execute();
                return ['encontrado' => true, 'mensaje' => 'Clave actualizada'];
            } else {
                echo $conexion->error;
                return ['encontrado' => false, 'mensaje' => 'La contraseña actual no coincide, asegurate de que sea la correcta'];
            }
                
            }else{
                return ['encontrado' => false, 'mensaje' => 'La contraseña solo se puede cambiar luego de 30 dias del ultimo cambio'];

            }
            
        } else {
            echo "Usuario no encontrado";
            return ['encontrado' => false, 'mensaje' => 'Usuario no encontrado'];
        }
        $stmt->close();
    }
    
}
