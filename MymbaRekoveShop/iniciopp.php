<?php
$conexion = new mysqli("localhost", "root", "", "mymba", "3306");
$conexion->set_charset("utf8");

$error_message = "";

if (!empty($_POST["submit"])) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $error_message = "CAMPOS VACIOS";
    } else {
        $correo = $_POST["email"];
        $contraseña =$_POST["password"];

        $query = "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contraseña'";
        $result = $conexion->query($query);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                header("location: index.html");
                exit();
            } else {
                $error_message = "USUARIO NO EXISTE";
            }
        } else {
            $error_message = "Error en la consulta: " . $conexion->error;
        }
    }
}
?>