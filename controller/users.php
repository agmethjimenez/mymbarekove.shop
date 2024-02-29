<?php
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");

$usuario = new Usuario();

$metodo = $_SERVER['REQUEST_METHOD'];
switch($metodo){
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $usuario->registrarse($data['identificacion'], $data['tipoid'], $data['nombre1'], $data['nombre2'], $data['apellido1'], $data['apellido2'], $data['telefono'], $data['email'], $data['password']);
    
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
            
            $usuario_id = $usuario_data['identificacion'];
            $nombre1 = $usuario_data['primerNombre'];
            $nombre2 = $usuario_data['segundoNombre'];
            $apellido1 = $usuario_data['primerApellido'];
            $apellido2 = $usuario_data['segundoApellido'];
            $telefono = $usuario_data['telefono'];
            $email = $usuario_data['email'];

            $usuario->actualizarDatos($usuario_id, $nombre1, $nombre2, $apellido1, $apellido2, $telefono, $email);

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Datos actualizados con éxito']);
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => 'JSON no válido']);
        }
        break;

}
?>