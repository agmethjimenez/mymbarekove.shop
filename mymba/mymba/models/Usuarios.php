<?php
require_once("../database/conexion.php");

class Usuario{

    public function registrarse($id_usuario,$tipoid, $name1, $name2, $lastname1, $lastname2, $telefono, $email, $clave){
    $hashedPassword = password_hash($clave, PASSWORD_BCRYPT);
    global $conexion;

    $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, clave)
            VALUES ('$id_usuario', '$tipoid', '$name1', '$name2', '$lastname1', '$lastname2', '$telefono','$email', '$hashedPassword')";
    if ($conexion->query($sql)) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar el usuario";
    }}

    public function inicioSesion($correo, $contraseña){
        global $conexion;
        $error_message = " ";
        $query = "SELECT * FROM usuarios WHERE email='$correo'";
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
                $error_message = "Contraseña incorrecta";
                        }
                } else {
                $error_message = "Usuario no existe";
                }
                } else {
                    $error_message = "Error en la consulta: " . $conexion->error;
                }
            }
        }
?>