<?PHP
session_start();
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
require_once '../models/Administrador.php';

$usuario = new Usuario();
$admin = new Admin();
$metodo = $_SERVER['REQUEST_METHOD'];


switch($metodo){
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        $resultUsuario = $usuario->Login($data['email'], $data['password']);

        if ($resultUsuario["accesso"]) {
            $_SESSION['id_usuario'] = $resultUsuario['usuario']['id'];
            $_SESSION['usuario_nombre'] = $resultUsuario['usuario']['nombre'];
            $_SESSION['usuario_apellido'] = $resultUsuario['usuario']['nombre'];
            echo json_encode(array('acceso' => true, 'mensaje' => 'Inicio de sesión exitoso como usuario'));
        } else {
            $resultAdmin = $admin->LogIn($data['email'], $data['password']);

            if ($resultAdmin['accesso']) {
                $_SESSION['id_admin'] = $resultAdmin['usuario']['id_admin'];
                $_SESSION['username'] = $resultAdmin['usuario']['username'];
                $_SESSION['email'] = $resultAdmin['usuario']['email'];
                echo json_encode(array('acceso' => true, 'mensaje' => 'Inicio de sesión exitoso como administrador'));
            } else {
                echo json_encode(array('acceso' => false, 'mensaje' => 'Credenciales incorrectas'));
            }
        }
        break;

}