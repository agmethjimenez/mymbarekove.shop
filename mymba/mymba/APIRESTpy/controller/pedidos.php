<?php
header('Content-Type: application/json');
require_once("../config/conexion.php");
require_once("../models/PedidosGET.php");
$pedido = new Pedido();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
  case 'get':
    $datos = $pedido->GETpedidos();;
    echo json_encode($datos);
    break;
  case 'Insert':
    $datos = $pedido->POSTusuario($body['identificacion'], $body['tipoid'], $body['primernombre'], $body['segundonombre'],$body['primerapellido'], $body['segundoapellido'],$body['telefono'],$body['correo'],$body['clave']);
    echo '!Insertado';
    break;
  case 'PUT':
    $datos = $pedido->PUTpedidos($body['idPedido'],$body['estado']);
    echo '!Actualizado';
    break;
  case 'DELETE':
    $datos = $pedido->DELETEpedidos($body['id']);
    echo "Borrado";
    break;
  case 'POSTd':
    $datos = $pedido->POSTdostablas($body['id'],$body['tipoid'], $body['primernombre'], $body['segundonombre'],$body['primerapellido'], $body['segundoapellido'],$body['telefono'],$body['correo'],$body['clave'],$body['idpedido'],$body['fecha'],$body['estado']);
    echo 'insertadoss2';
}

?>