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

$headers = getallheaders();
$receivedToken  = $headers['token'] ?? null;

switch ($metodo) {

    case 'POST':
        $auth->setToken($_ENV['CAMBIO_PASSWORD_KEY']);
        if ($auth->verificarToken($receivedToken)) {
            $data = json_decode(file_get_contents('php://input'), true);
            $password = $data['password'];
            $usuario->setEmail($email);
            $result = $usuario->actualizarCredenciales($conexion, $password);
            if ($result['status']) {
                http_response_code(200);
                echo json_encode(["message" => "Actualizado correctamente"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Error al actualizar"]);
            }
        }else{
            http_response_code(401);
            echo json_encode(["status"=>"Acceso no autorizado"]);
        }

        break;
}
