<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}
header("Access-Control-Allow-Headers: Authorization, Content-Type");
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); 
$dotenv->load();
require_once("../models/Auth.php");
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
require_once '../models/Administrador.php';
$database = new Database();
$conexion = $database->connect();
$auth = new Auth();
$usuario = new Usuario();
$admin = new Admin();

$headers = getallheaders();
$authorizationHeader = $headers['token'] ?? null;



$metodo = $_SERVER['REQUEST_METHOD'];

$path = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';
$BidUsuario = explode('/',$path);
$idusuario = ($path!=='/') ? end($BidUsuario):null;

switch ($metodo) {
    case 'GET':
        $auth->setToken($_ENV['API_KEY_GET']);
        if ($auth->verificarToken($authorizationHeader)) {
        $funcion = $usuario->GETusuarios($conexion,$idusuario);
        http_response_code(200);
        echo json_encode($funcion);
        }else{
        header('HTTP/1.0 401 Unauthorized');
        echo json_encode(['error' => 'Acceso no autorizado']);
        exit;
        }
        break;
    case 'POST':
        $auth->setToken($_ENV['API_POST_USER']);
        if ($auth->verificarToken($authorizationHeader)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $usuario->setIdentificacion($data['identificacion']);
            $usuario->setTipoId($data['tipoid']);
            $usuario->setNombre1($data['nombre1']);
            $usuario->setNombre2($data['nombre2']);
            $usuario->setApellido1($data['apellido1']);
            $usuario->setApellido2($data['apellido2']);
            $usuario->setTelefono($data['telefono']);
            $usuario->setEmail($data['email']);
            $result = $usuario->registrarse($conexion,$data['password']);
            if ($result["status"]) {
                http_response_code(201);
                echo json_encode(array('status' => true, 'mensaje' => $result['mensaje']));
            } else {
                echo json_encode(array('status' => false, 'mensaje' => $result['mensaje']));
            }
        }else{
            http_response_code(401);
            echo json_encode(array('exito'=>false,'mensaje' => 'Acceso no autorizado'));
            exit;
        }
        
        break;
    case 'PUT':
        $auth->setToken($_ENV['API_POST_USER']);
        if ($auth->verificarToken($authorizationHeader)){

        
        $jsonData = file_get_contents('php://input');
        $usuario_data = json_decode($jsonData, true);

        if ($usuario_data !== null) {
        $usuario->setIdentificacion($usuario_data['identificacion']);
        $usuario->setNombre1($usuario_data['primerNombre']);
        $usuario->setNombre2($usuario_data['segundoNombre']);
        $usuario->setApellido1($usuario_data['primerApellido']);
        $usuario->setApellido2($usuario_data['segundoApellido']);
        $usuario->setTelefono($usuario_data['telefono']);
        $usuario->setEmail($usuario_data['email']);

            $usuario_id = $usuario_data['identificacion'];
            $nombre1 = $usuario_data['primerNombre'];
            $nombre2 = $usuario_data['segundoNombre'];
            $apellido1 = $usuario_data['primerApellido'];
            $apellido2 = $usuario_data['segundoApellido'];
            $telefono = $usuario_data['telefono'];
            $email = $usuario_data['email'];

            $usuario->actualizarDatos($conexion);

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['status'=>true,'message' => 'Datos actualizados con exito']);
        } else {
            header('Content-Type: application/json', true, 400);
            http_response_code(400);
            echo json_encode(['status' => 'JSON no válido']);
        }
    }else{
        http_response_code(401);
        echo json_encode(array('status'=>false,'mensaje' => 'Acceso no autorizado'));
        exit;
    }
        break;
    case 'DELETE':
        $auth->setToken($_ENV['dku']);
        if ($auth->verificarToken($authorizationHeader)){
        $result = $admin->DesactivarUsuario($conexion,$idusuario);
        if ($result['status']) {
            http_response_code(200);
            echo json_encode(array('status' => true, 'mensaje' => $result['mensaje']));
        } else {
            http_response_code(400);
            echo json_encode(array('status' => false, 'mensaje' => $result['mensaje']));
        }
    }else{
        http_response_code(401);
        echo json_encode(array('status'=>false,'mensaje' => 'Acceso no autorizado'));
        exit;
    }
        break;
}

?>