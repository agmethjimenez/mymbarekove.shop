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

    // Encriptar la contraseña
    $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, clave)
            VALUES ('$id_usuario', '$cod_id', '$primernombre', '$segundonombre', '$primerapellido', '$segundoapellido', '$telefono', '$email', '$hashedPassword')";

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
