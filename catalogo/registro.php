<?php
require_once("../models/Usuarios.php");
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

$usuario = new Usuario();
$usuario->registrarse($id_usuario, $cod_id, $primernombre, $segundonombre, $primerapellido, $segundoapellido,$telefono, $email, $contrasena);
