<?php
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();
header('Content-Type: application/json');
require_once("../models/Proveedor.php");
require_once("../models/Administrador.php");
require_once("../database/conexion.php");
require_once("../models/Auth.php");
$auth = new Auth;
$database = new Database();
$conexion = $database->connect();
$proveedor = new Proveedor();
$admin = new Admin;
$metodo = $_SERVER['REQUEST_METHOD'];

$headers = getallheaders();
$authorizationHeader = $headers['token'] ?? null;

$path = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO'] : '/';
$Bidproveedor = explode('/', $path);
$idproveedor = ($path !== '/') ? end($Bidproveedor) : null;
$busqueda = $_GET['nm'] ?? null;


switch ($metodo) {
    case 'GET':
        $auth->setToken($_ENV['PROVEDOR_GET']);
        if($auth->verificarToken($authorizationHeader)){
        $result = $proveedor->GETproveedores($conexion, $idproveedor,$busqueda);
        http_response_code(200);
        echo json_encode($result);
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('exito'=>false,'message' => 'Acceso no autorizado'));
            exit;
        }
        break;
    case 'POST':
        $auth->setToken($_ENV['PROVEDOR_POST']);
        if($auth->verificarToken($authorizationHeader)){
        $data = json_decode(file_get_contents('php://input'), true);
        $proveedor->setIdProveedor(rand(1000,9999));
        $proveedor->setNombre($data['nombre']);
        $proveedor->setCiudad($data['ciudad']);
        $proveedor->setCorreo($data['correo']);
        $proveedor->setTelefono($data['telefono']);

        $result = $proveedor->POSTproveedores($conexion);

        if ($result['status']) {
            http_response_code(201);
            echo json_encode(array("status" => true, "mensaje" => $result['mensaje']));
        } else {
            echo json_encode(array("status" => false, "mensaje" => $result['mensaje']));
        }
    }else{
        header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('exito'=>false,'message' => 'Acceso no autorizado'));
            exit;
    }
        break;
    case 'PUT':
        $auth->setToken($_ENV['PROVEDOR_PUT']);
        if($auth->verificarToken($authorizationHeader)){    
        $data = json_decode(file_get_contents('php://input'), true);
        $proveedor->setNombre($data['nombreP']);
        $proveedor->setCiudad($data['ciudad']);
        $proveedor->setCorreo($data['correo']);
        $proveedor->setTelefono($data['telefono']);
        $proveedor->setIdProveedor($data['idProveedor']);

        $result = $proveedor->PUTprovedores($conexion);
        if($result['status']){
            http_response_code(200);
            echo json_encode(['status'=>true,'mensaje'=>$result['mensaje']]);
        }else{
            http_response_code(400);
            echo json_encode(['status'=>false,'mensaje'=>$result['mensaje']]);
        }
    }else{
        header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('status'=>false,'message' => 'Acceso no autorizado'));
            exit;
    }
        break;
    case 'DELETE':
        $auth->setToken($_ENV['dku']);
        if($auth->verificarToken($authorizationHeader)){
        $result = $admin->DesactivarProveedor($conexion,$idproveedor);
        if($result['status']){
            http_response_code(200);
            echo json_encode(['status'=>true,'message'=>$result['message']]);
        }else{
            http_response_code(400);
            echo json_encode(['status'=>false,'message'=>$result['message']]);
        }
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('status'=>false,'message' => 'Acceso no autorizado'));
            exit;
        }
        break;
    
    default:
        break;
}