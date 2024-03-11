<?php

header('Content-Type: application/json');
require_once("../models/Proveedor.php");
require_once("../database/conexion.php");

$database = new Database();
$conexion = $database->connect();
$proveedor = new Proveedor();
$metodo = $_SERVER['REQUEST_METHOD'];

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
    
    default:
        break;
}