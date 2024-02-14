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
            $id_usuario = $_SESSION['id_usuario'];
            $id_pedido = substr(uniqid(), 0, 10);
            $ciudad = $pedido_data['ciudad'];
            $direccion = $pedido_data['direccion'];
            $detalles = $pedido_data['detalles'];
            $totalP = $pedido_data['totalp'];
            
            foreach ($detalles as $producto) {
                $id_producto = $producto['id'];
                $cantidad = $producto['cantidad'];
                $total = $producto['total'];

            }
            $pedido->Traerpedido($id_usuario, $id_pedido,$ciudad, $direccion,$detalles,$totalP);


            echo json_encode(array('exito' => true, 'mensaje' => 'Pedido exitoso'));
        } catch (Exception $e) {
            // En caso de error, devuelve un mensaje de error
            echo json_encode(array('exito' => false, 'mensaje' => 'Error en el pedido: ' . $e->getMessage()));
        }
    break;
}
