<?php
require_once("../models/Usuarios.php");
require_once("../models/Pedidos.php");
require_once("../database/conexion.php");
session_start();
$pedido = new Pedido();

$metodo = $_SERVER['REQUEST_METHOD'];

switch($metodo){
    case 'GET':
        $jsonData = file_get_contents('php://input');
        $usuario_data = json_decode($jsonData, true);

        echo json_encode($pedido->GetPedidos());
        break;


        case 'POST':
            $jsonData = file_get_contents('php://input');
            $pedido_data = json_decode($jsonData, true);
    
            try {
                $pedido = new Pedido(); // Reemplaza 'ruta_hacia_tu_clase_pedido.php' con la ruta correcta
                $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : (isset($_COOKIE['id_usuario']) ? $_COOKIE['id_usuario'] : null);
                $id_pedido = substr(uniqid(), 0, 10);
                $ciudad = $pedido_data['ciudad'];
                $direccion = $pedido_data['direccion'];
                $detalles = $pedido_data['detalles'];
                $totalP = $pedido_data['totalp'];
                $datospago = $pedido_data['datospago'];
    
                $respuesta = $pedido->Traerpedido($id_usuario, $id_pedido, $ciudad, $direccion, $detalles, $totalP, $datospago);
    
                echo $respuesta;
            } catch (Exception $e) {
                echo json_encode(array('exito' => false, 'mensaje' => 'Error en el pedido: ' . $e->getMessage()));
            }
        break;

        

}
