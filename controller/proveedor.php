<?php

header('Content-Type: application/json');
require_once("../models/Proveedor.php");
require_once("../models/Administrador.php");
require_once("../database/conexion.php");
require_once("../models/Auth.php");
require_once("../config.php");
$auth = new Auth;
$database = new Database();
$conexion = $database->connect();
$proveedor = new Proveedor();
$admin = new Admin;
$metodo = $_SERVER['REQUEST_METHOD'];

$headers = getallheaders();
$authorizationHeader = $headers['Authorization'] ?? null;

$path = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO'] : '/';
$Bidproveedor = explode('/', $path);
$idproveedor = ($path !== '/') ? end($Bidproveedor) : null;

switch ($metodo) {
    case 'GET':
        $result = $proveedor->GETproveedores($conexion, $idproveedor);
        echo json_encode($result);
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        $proveedor->setIdProveedor(rand(1000,9999));
        $proveedor->setNombre($data['nombre']);
        $proveedor->setCiudad($data['ciudad']);
        $proveedor->setCorreo($data['correo']);
        $proveedor->setTelefono($data['telefono']);

        $result = $proveedor->POSTproveedores($conexion);

        if ($result['acceso']) {
            echo json_encode(array("acceso" => true, "mensaje" => $result['mensaje']));
        } else {
            echo json_encode(array("acceso" => false, "mensaje" => $result['mensaje']));
        }  
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $proveedor->setNombre($data['nombreP']);
        $proveedor->setCiudad($data['ciudad']);
        $proveedor->setCorreo($data['correo']);
        $proveedor->setTelefono($data['telefono']);
        $proveedor->setIdProveedor($data['idProveedor']);

        $result = $proveedor->PUTprovedores($conexion);
        if($result['acceso']){
            echo json_encode(['status'=>true,'mensaje'=>$result['mensaje']]);
        }else{
            echo json_encode(['status'=>false,'mensaje'=>$result['mensaje']]);
        }
        break;
    case 'DELETE':
        $auth->setToken(dku);
        if($auth->verificarToken($authorizationHeader)){
        $result = $admin->DesactivarProveedor($conexion,$idproveedor);
        if($result['status']){
            echo json_encode(['status'=>true,'message'=>$result['message']]);
        }else{
            echo json_encode(['status'=>false,'message'=>$result['message']]);
        }
        }else{
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('exito'=>false,'message' => 'Acceso no autorizado'));
            exit;
        }
        break;
    
    default:
        break;
}