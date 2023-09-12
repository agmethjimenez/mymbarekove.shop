<?php
// config.php

$database = "mymba";
$user = 'root';
$password = '';

try {
    $conn = new PDO('mysql:host=localhost;dbname=' . $database, $user, $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
