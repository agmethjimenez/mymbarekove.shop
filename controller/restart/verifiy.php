<?php
require '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

header('Content-Type: application/json');
require_once '../../models/Auth.php';
require_once("../../models/Usuarios.php");
require_once("../../database/conexion.php");
require_once '../../models/Administrador.php';

$database = new Database();
$conexion = $database->connect();
$auth = new Auth();
$usuario = new Usuario();
$admin = new Admin();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $token = $data['token'];
        $codigo = $data['codigo'];
        $usuario->setEmail($data['email']);
        $result = $usuario->VerificarExistenciayCaducidad($conexion,$token,$codigo);
        if($result['status']){
            http_response_code(200);
            echo json_encode(["message"=>"Verificado exitosamente"]);
        }else{
            http_response_code(400);
            echo json_encode(["message"=>$result["error"]]);
        }
        break;
}
