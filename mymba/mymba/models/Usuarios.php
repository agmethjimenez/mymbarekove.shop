<?php
require_once("../database/conexion.php");
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
}
