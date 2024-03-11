<?php
header('Content-Type: application/json');
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
require_once '../models/Administrador.php';
$database = new Database();
$conexion = $database->connect();
$usuario = new Usuario();
$admin = new Admin();
$metodo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';
$BidUsuario = explode('/',$path);
$idusuario = ($path!=='/') ? end($BidUsuario):null;

switch ($metodo) {
    case 'GET':
        $funcion = $usuario->GETusuarios($conexion,$idusuario);
        echo json_encode($funcion);
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $usuario->setIdentificacion($data['identificacion']);
        $usuario->setTipoId($data['tipoid']);
        $usuario->setNombre1($data['nombre1']);
        $usuario->setNombre2($data['nombre2']);
        $usuario->setApellido1($data['apellido1']);
        $usuario->setApellido2($data['apellido2']);
        $usuario->setTelefono($data['telefono']);
        $usuario->setEmail($data['email']);
        $result = $usuario->registrarse($conexion,$data['password']);
        if ($result["success"]) {
            echo json_encode(array('exito' => true, 'mensaje' => $result['mensaje']));
        } else {
            echo json_encode(array('exito' => false, 'mensaje' => $result['mensaje']));
        }
        break;
    case 'PUT':
        $jsonData = file_get_contents('php://input');
        $usuario_data = json_decode($jsonData, true);

        if ($usuario_data !== null) {
        $usuario->setIdentificacion($usuario_data['identificacion']);
        $usuario->setNombre1($usuario_data['primerNombre']);
        $usuario->setNombre2($usuario_data['segundoNombre']);
        $usuario->setApellido1($usuario_data['primerApellido']);
        $usuario->setApellido2($usuario_data['segundoApellido']);
        $usuario->setTelefono($usuario_data['telefono']);
        $usuario->setEmail($usuario_data['email']);

            $usuario_id = $usuario_data['identificacion'];
            $nombre1 = $usuario_data['primerNombre'];
            $nombre2 = $usuario_data['segundoNombre'];
            $apellido1 = $usuario_data['primerApellido'];
            $apellido2 = $usuario_data['segundoApellido'];
            $telefono = $usuario_data['telefono'];
            $email = $usuario_data['email'];

            $usuario->actualizarDatos($conexion);

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Datos actualizados con éxito']);
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => 'JSON no válido']);
        }
        break;
    case 'DELETE':
        $result = $admin->DesactivarUsuario($conexion,$idusuario);
        if ($result['acceso']) {
            echo json_encode(array('exito' => true, 'mensaje' => $result['mensaje']));
        } else {
            echo json_encode(array('exito' => false, 'mensaje' => $result['mensaje']));
        }
        break;
}

?>