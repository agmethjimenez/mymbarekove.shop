<?php
include_once '../../database/conexion.php';
include_once '../../models/Pedidos.php';
$obpedido = new Pedido();
$database = new Database();
$conexion = $database->connect();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = json_decode(file_get_contents("php://input"), true);

    if (isset($jsonData['idproducto']) && isset($jsonData['precio']) && isset($jsonData['idPedido'])) {
        $idPedido = $jsonData['idPedido'];
        $idproducto = $jsonData['idproducto'];
        $precio = $jsonData['precio'];

        $verificarQuery = "SELECT * FROM detallepedido WHERE idPedido = ? AND idProducto = ?";
        $verificarStmt = $conexion->prepare($verificarQuery);
        $verificarStmt->bind_param("ss", $idPedido, $idproducto);
        $verificarStmt->execute();
        
        $verificarStmt->bind_result($idPedidoExistente, $idProductoExistente, $cantidadExistente, $precioExistente);

        $verificarStmt->fetch();
        
        if ($idPedidoExistente !== null) {
            echo json_encode(['bien' => false, 'mensaje' => 'El producto ya está agregado']);
        } else {
            $insertarQuery = "INSERT INTO detallepedido (idPedido, idProducto, cantidad, total) VALUES (?, ?, 1, ?)";
            $insertarStmt = $conexion->prepare($insertarQuery);
            $insertarStmt->bind_param("sss", $idPedido, $idproducto, $precio);

            if ($insertarStmt->execute()) {
                echo json_encode(['bien' => true, 'mensaje' => 'Producto agregado']);
            } else {
                echo json_encode(['bien' => false, 'mensaje' => 'Producto no agregado']);
            }
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Datos no válidos']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>

