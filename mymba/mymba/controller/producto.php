<?php
require_once("../models/Productos.php");
require_once("../database/conexion.php");

$producto = new Producto();

$metodo = $_SERVER['REQUEST_METHOD'];
switch($metodo){
    case 'GET':
        $jsonData = file_get_contents('php://input');
        $usuario_data = json_decode($jsonData, true);

        echo json_encode($producto->GetProductos());
        break;

}
?>