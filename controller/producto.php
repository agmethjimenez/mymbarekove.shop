
<?php
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();
header("Access-Control-Allow-Origin: *");

// Permitir los métodos de solicitud que deseas permitir
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}
// Permitir los encabezados que deseas permitir en las solicitudes
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header('Content-Type: application/json');
require '../models/Auth.php';
require '../models/Administrador.php';
require_once("../models/Productos.php");
require_once("../database/conexion.php");
$database = new Database();
$conexion = $database->connect();
$producto = new Producto();
$auth = new Auth;
$headers = getallheaders();
$authorizationHeader = $headers['token'] ?? null;

$metodo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$Bidproducto = explode('/', $path);
$idPRODUCTO = ($path !== '/') ? end($Bidproducto) : null;

$busqueda = $_GET['busqueda'] ?? null;
$categoria = $_GET['categoria'] ?? null;
$tokenadmin = $_GET['tk'] ?? null;

switch ($metodo) {
    case 'GET':
        $token = $_ENV['KEY_PRODUCTS'];
        $auth->setToken($token);
        if($auth->verificarToken($authorizationHeader)){
            $jsonData = file_get_contents('php://input');
            $usuario_data = json_decode($jsonData, true);
            echo json_encode($producto->GetProductos($conexion, $idPRODUCTO, $busqueda, $categoria));
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }
        
        break;
    case 'POST':
        $auth->setToken($_ENV['POST_PRODUCT']);
        if($auth->verificarToken($authorizationHeader)){
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

            $idadmin = $producto_data['idadmin'];

            $result = $producto->AgregarProducto($conexion,$idadmin);
        if ($result["status"]) {
            echo json_encode(array('status' => true, 'mensaje' => $result['mensaje']));
        } else {
            echo json_encode(array('status' => false, 'mensaje' => $result['mensaje'], 'error'=>$result['error']));
        }
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }
        
        break;
    case 'PUT':
        $auth->setToken($_ENV['PUT_PRODUCT']);
        if($auth->verificarToken($authorizationHeader)){
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
        if ($result["status"]){
            echo json_encode(["status"=> true,"mensaje" => $result['mensaje']]);
        }else{
            echo json_encode(["status"=> false,"mensaje" => $result['mensaje']]);
        }
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }
        
        break;
    case 'DELETE':
        $auth->setToken($_ENV['dku']);
        if ($auth->verificarToken($authorizationHeader)) {
            $result = Admin::DesactivarProducto($conexion, $idPRODUCTO,$tokenadmin);
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
