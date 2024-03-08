
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
    case 'POST':
        $jsonData = file_get_contents('php://input');
        $producto_data = json_decode($jsonData, true);

        $result = $producto->AgregarProducto($producto_data['proveedor'],$producto_data['nombre'],$producto_data['descripcion'],$producto_data['contenido'],$producto_data['precio'],$producto_data['marca'],$producto_data['categoria'],$producto_data['stock'],$producto_data['imagen']);
        if($result["accesso"]){
            echo json_encode(array('exito' => true, 'mensaje' => $result['mensaje']));
        }else{
            echo json_encode(array('exito' => false, 'mensaje' => $result['mensaje']));
        }
        break;


}
?>
