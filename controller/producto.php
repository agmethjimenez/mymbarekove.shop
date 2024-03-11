
<?php
header('Content-Type: application/json');
require_once("../models/Productos.php");
require_once("../database/conexion.php");
$database = new Database();
$conexion = $database->connect();
$producto = new Producto();

$metodo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$Bidproducto = explode('/', $path);
$idPRODUCTO = ($path !== '/') ? end($Bidproducto) : null;

switch ($metodo) {
    case 'GET':
        $jsonData = file_get_contents('php://input');
        $usuario_data = json_decode($jsonData, true);

        echo json_encode($producto->GetProductos($conexion, $idPRODUCTO));
        break;
    case 'POST':
        $jsonData = file_get_contents('php://input');
        $producto_data = json_decode($jsonData, true);
        $producto->setIdProducto(rand(1000, 9999));
        $producto->setProveedor($producto_data['proveedor']);
        $producto->setNombre($producto_data['nombre']);
        $producto->setDescripcion($producto_data['descripcion']);
        $producto->setContenido($producto_data['contenido']);
        $producto->setPrecio($producto_data['precio']);
        $producto->setMarca($producto_data['marca']);
        $producto->setCategoria($producto_data['categoria']);
        $producto->setStock($producto_data['stock']);
        $producto->setImagen($producto_data['imagen']);

        $result = $producto->AgregarProducto($conexion, $producto_data['proveedor'], $producto_data['nombre'], $producto_data['descripcion'], $producto_data['contenido'], $producto_data['precio'], $producto_data['marca'], $producto_data['categoria'], $producto_data['stock'], $producto_data['imagen']);
        if ($result["accesso"]) {
            echo json_encode(array('exito' => true, 'mensaje' => $result['mensaje']));
        } else {
            echo json_encode(array('exito' => false, 'mensaje' => $result['mensaje']));
        }
        break;
}
?>
