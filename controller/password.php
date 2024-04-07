<?php
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();
require_once("../models/Usuarios.php");
require_once('../models/Auth.php');
require_once("../database/conexion.php");
header('Content-Type: application/json');
$usuario = new Usuario();
$auth = new Auth;
$metodo = $_SERVER['REQUEST_METHOD'];
$headers = getallheaders();
$authorizationHeader = $headers['Authorization'] ?? null;
switch ($metodo) {
    case 'PUT':
        $auth->setToken($_ENV['PASSWORD_TOKEN']);
        if ($auth->verificarToken($authorizationHeader)) {

            $jsonData = file_get_contents('php://input');
            $usuario_data = json_decode($jsonData, true);

            if ($usuario_data !== null) {
                $usuario_id = $usuario_data['identificacion'];
                $claveactual = $usuario_data['claveactual'];
                $clavenueva = $usuario_data['clavenueva'];
                $clavenueva2 = $usuario_data['clavenueva2'];

                try {
                    if (empty($usuario_id) || empty($claveactual) || empty($clavenueva) || empty($clavenueva2)) {
                        header('Content-Type: application/json', true, 400);
                        echo json_encode(array('exito' => false, 'mensaje' => 'Por favor, complete todos los campos'));
                    } elseif ($clavenueva != $clavenueva2) {
                        header('Content-Type: application/json', true, 400);
                        echo json_encode(array('exito' => false, 'mensaje' => 'Las contraseñas no coinciden'));
                    } else {
                        $result = $usuario->cambiarClave($usuario_id, $claveactual, $clavenueva, $clavenueva2);
                        if ($result['encontrado']) {
                            header('Content-Type: application/json');
                            echo json_encode(array('exito' => true, 'mensaje' => $result['mensaje']));
                        } else {
                            header('Content-Type: application/json', true, 400);
                            echo json_encode(array('noexito' => true, 'mensaje' => $result['mensaje']));
                        }
                    }
                } catch (Exception $e) {
                    header('Content-Type: application/json', true, 400);
                    echo json_encode(array('exito' => false, 'mensaje' => $e->getMessage()));
                }
            } else {
                header('Content-Type: application/json', true, 400);
                echo json_encode(array('exito' => false, 'mensaje' => 'Datos incorrectos'));
            }
        } else {
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }
        break;
}
