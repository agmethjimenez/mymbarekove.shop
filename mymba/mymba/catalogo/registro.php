<?php
include_once("../database/conexion.php");

$id_usuario = $_POST['identificacion'];
$cod_id = $_POST['tipoIdentificacion'];
$primernombre = $_POST['nombre1'];
$segundonombre = $_POST['nombre2'];
$primerapellido = $_POST['apellido1'];
$segundoapellido = $_POST['apellido2'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['password'];
    // Encriptar la contraseña
    $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, clave)
            VALUES ('$id_usuario', '$cod_id', '$primernombre', '$segundonombre', '$primerapellido', '$segundoapellido', '$telefono', '$email', '$hashedPassword')";
    if ($conexion->query($sql)) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar el usuario";
    }
?>
