<?PHP
session_start();
header('Content-Type: application/json');
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
require_once '../models/Administrador.php';
$database = new Database();
$conexion = $database->connect();
$usuario = new Usuario();
$admin = new Admin();
$metodo = $_SERVER['REQUEST_METHOD'];


switch($metodo){
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $usuario->setEmail($data['email']);
        $resultUsuario = $usuario->Login($conexion, $data['password']);

        if ($resultUsuario["accesso"]) {
            echo json_encode(array('acceso' => true,'tipo'=>"user", 'mensaje' => 'Inicio de sesión exitoso como usuario',"data" => $resultUsuario['usuario']));
        } else {
            $resultAdmin = $admin->LogIn($data['email'], $data['password']);

            if ($resultAdmin['accesso']) {
                echo json_encode(array('acceso' => true,'tipo'=>"admin", 'mensaje' => 'Inicio de sesión exitoso como administrador', "data" => $resultAdmin['usuario']));
            } else {
                echo json_encode(array('acceso' => false, 'mensaje' => $resultUsuario['mensaje']));
            }
        }
        break;

}