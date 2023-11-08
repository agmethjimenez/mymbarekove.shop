<?php
session_start();

require_once("../database/conexion.php");
$conexion->set_charset("utf8");

$error_message = "";

if (!empty($_POST["submit"])) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $error_message = "CAMPOS VACIOS";
    } else {
        $correo = $_POST["email"];
        $contraseña = $_POST["password"];

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
