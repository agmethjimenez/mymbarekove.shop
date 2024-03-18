
<?php
header('Content-Type: application/json');
require '../config.php';
require '../models/Auth.php';
require '../models/Administrador.php';
require_once("../models/Productos.php");
require_once("../database/conexion.php");
$database = new Database();
$conexion = $database->connect();
$producto = new Producto();
$auth = new Auth;
$headers = getallheaders();
$authorizationHeader = $headers['Authorization'] ?? null;

$metodo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$Bidproducto = explode('/', $path);
$idPRODUCTO = ($path !== '/') ? end($Bidproducto) : null;

switch ($metodo) {
    case 'GET':
        $auth->setToken(KEY_PRODUCTS);
        if($auth->verificarToken($authorizationHeader)){
            $jsonData = file_get_contents('php://input');
            $usuario_data = json_decode($jsonData, true);
            echo json_encode($producto->GetProductos($conexion, $idPRODUCTO));
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }
        
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

        $result = $producto->AgregarProducto($conexion);
        if ($result["accesso"]) {
            echo json_encode(array('exito' => true, 'mensaje' => $result['mensaje']));
        } else {
            echo json_encode(array('exito' => false, 'mensaje' => $result['mensaje']));
        }
        break;
    case 'PUT':
        $jsonData = file_get_contents('php://input');
        $producto_data = json_decode($jsonData, true);

        $producto->setIdProducto($producto_data['idProducto']);
        $producto->setNombre($producto_data['nombre']);
        $producto->setDescripcion($producto_data['descripcionP']);
        $producto->setContenido($producto_data['contenido']);
        $producto->setPrecio($producto_data['precio']);
        $producto->setStock($producto_data['cantidadDisponible']);
        $producto->setImagen($producto_data['imagen']);

        $result = $producto->ActualizarProducto($conexion);

        if ($result["accesso"]){
            echo json_encode(["status"=> true,"mensaje" => $result['mensaje']]);
        }else{
            echo json_encode(["status"=> false,"mensaje" => $result['mensaje']]);
        }
        break;
    case 'DELETE':
        $auth->setToken(dku);
        if ($auth->verificarToken($authorizationHeader)) {
            $result = Admin::DesactivarProducto($conexion, $idPRODUCTO);
            if($result['status']){
                echo json_encode(["status"=>true,"mensaje"=>$result['message']]);
            }else{
                echo json_encode(["status"=>false,"mensaje"=>$result['message']]);
            }
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('exito'=>false,'mensaje' => 'Acceso no autorizado'));
            exit;
        }
        
        break;
}
?>
