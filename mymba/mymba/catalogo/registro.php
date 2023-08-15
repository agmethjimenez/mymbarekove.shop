<?php

$id_usuario = $_POST['identificacion'];
$cod_id = $_POST['tipoIdentificacion'];
$primernombre = $_POST['nombre1'];
$segundonombre = $_POST['nombre2'];
$primerapellido = $_POST['apellido1'];
$segundoapellido = $_POST['apellido2'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['password'];


$database = "mymba";
$user = 'root';
$password = '';

try {
    $conn = new PDO('mysql:host=localhost;dbname=' . $database, $user, $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    
    $sql = "INSERT INTO usuarios (codId,identificacion, primerNombre, segundoNombre, primerApellido, segundoApellido, correo, telefono, clave)
            VALUES ('$cod_id', '$id_usuario', '$primernombre', '$segundonombre', '$primerapellido', '$segundoapellido', '$email', '$telefono', '$contrasena')";

    if ($conn->exec($sql)) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar el usuario";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$conn = null;
?>