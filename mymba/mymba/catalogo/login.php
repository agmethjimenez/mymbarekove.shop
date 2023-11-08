<?php
session_start();
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
$conexion->set_charset("utf8");

$error_message = "";
if (!empty($_POST["submit"])) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $error_message = "CAMPOS VACIOS";
    } else {
        $correo = $_POST["email"];
        $contraseña = $_POST["password"];

        $usuario = new Usuario();
        $usuario->inicioSesion($correo,$contraseña);       
}}
?>
