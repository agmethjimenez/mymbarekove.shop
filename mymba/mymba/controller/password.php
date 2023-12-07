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
            $clavenueva2 = $usuario_data['clavenueva2'];

            try {
                if (empty($usuario_id) || empty($claveactual) || empty($clavenueva) || empty($clavenueva2)) {
                    header('Content-Type: application/json', true, 400);
                    echo json_encode(array('exito' => false, 'mensaje' => 'Por favor, complete todos los campos'));
                } elseif ($clavenueva != $clavenueva2) {
                    header('Content-Type: application/json', true, 400);
                    echo json_encode(array('exito' => false, 'mensaje' => 'Las contraseñas no coinciden'));
                } else {
                    $usuario->cambiarClave($usuario_id, $claveactual, $clavenueva, $clavenueva2);
                    header('Content-Type: application/json');
                    echo json_encode(array('exito' => true, 'mensaje' => 'Clave actualizada'));
                }
            } catch (Exception $e) {
                header('Content-Type: application/json', true, 400);
                echo json_encode(array('exito' => false, 'mensaje' => $e->getMessage()));
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(array('exito' => false, 'mensaje' => 'Datos incorrectos'));
        }
        break;
}

?>