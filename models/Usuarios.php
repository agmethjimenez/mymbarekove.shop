<?php
require_once("../database/conexion.php");
$database = new Database();
$conexion = $database->connect();
class Usuario
{

    public function registrarse($id_usuario, $tipoid, $name1, $name2, $lastname1, $lastname2, $telefono, $email, $clave)
    {
        $hashedPassword = password_hash($clave, PASSWORD_BCRYPT);
        global $conexion;

        $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email,activo,clave)
            VALUES (?,?,?,?,?,?,?,?,1,?)";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("sssssssss",$id_usuario,$tipoid,$name1,$name2,$lastname1,$lastname2,$telefono,$email,$hashedPassword);
        if ($bin->execute()) {
            echo "Registro exitoso";
        } else {
            echo "Error al registrar el usuario", $conexion->error ;
        }
    }

    public function inicioSesion($correo, $contraseña)
    {
        global $conexion;
        $error_message = " ";
        $query = "SELECT * FROM usuarios WHERE email='$correo' AND activo = 1";
        $result = $conexion->query($query);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['clave'];

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
            echo "Las contraseñas no coinciden";
            return;
        }
        $query = "SELECT clave FROM usuarios WHERE identificacion = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['clave'];
    
            if (password_verify($passwordactual, $hashedPassword)) {
                $hashedNuevaPassword = password_hash($passwordnueva, PASSWORD_BCRYPT);
                $sql = "UPDATE usuarios SET clave = ? WHERE identificacion = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ss", $hashedNuevaPassword, $id);
                $stmt->execute();
            } else {
                echo $conexion->error;
            }
        } else {
            echo "Usuario no encontrado";
        }
        $stmt->close();
    }
    
}
