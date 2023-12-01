<?php
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");

$usuario = new Usuario();

$metodo = $_SERVER['REQUEST_METHOD'];
switch($metodo){
    case 'PUT':
        $jsonData = file_get_contents('php://input');
        $usuario_data = json_decode($jsonData, true);
        
        if ($usuario_data !== null) {
            
            $usuario_id = $usuario_data['identificacion'];
            $claveactual = $usuario_data['claveactual'];
            $clavenueva = $usuario_data['clavenueva'];
            $clavenueva2 = $usuario_data['clavenuevados'];

            $usuario->cambiarClave($usuario_id,$claveactual,$clavenueva,$clavenueva2);

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Datos actualizados con éxito']);
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => 'JSON no válido']);
        }
        break;

}
?>