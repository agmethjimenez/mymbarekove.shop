<?php
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();
header('Content-Type: application/json');
require_once '../models/Auth.php';
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
require_once '../models/Administrador.php';

$database = new Database();
$conexion = $database->connect();
$auth = new Auth();
$usuario = new Usuario();
$admin = new Admin();
$metodo = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: *');

$expectedToken = $_ENV['login'];

$headers = getallheaders();
$receivedToken  = $headers['token'] ?? null;

switch ($metodo) {
    case 'POST':
        if ($receivedToken === $expectedToken) {
            $data = json_decode(file_get_contents('php://input'), true);
            $usuario->setEmail($data['email']);
            $resultUsuario = $usuario->Login($conexion, $data['password']);

            if ($resultUsuario["accesso"]) {
                echo json_encode(array('acceso' => true, 'tipo' => "user", 'mensaje' => 'Inicio de sesión exitoso como usuario', "data" => $resultUsuario['usuario']));
            } else {
                $resultAdmin = $admin->LogIn($data['email'], $data['password']);

                if ($resultAdmin['accesso']) {
                    http_response_code(200);
                    echo json_encode(array('acceso' => true, 'tipo' => "admin", 'mensaje' => 'Inicio de sesión exitoso como administrador', "data" => $resultAdmin['usuario']));
                } else {
                    http_response_code(400);
                    echo json_encode(array('acceso' => false, 'mensaje' => $resultUsuario['mensaje']));
                }
            }
        } else {
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }
        break;
}
