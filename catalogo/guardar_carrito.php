<?php
session_start();

header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    $datos = json_decode($jsonData, true);

    $_SESSION['carrito'] = $datos['detalles'];
    if (isset($_SESSION['carrito'])) {
        echo json_encode(array("mensaje" => "Datos del carrito recibidos y guardados correctamente en la sesión."));
    } else {
        echo json_encode(array("error" => "Error al guardar los datos del carrito en la sesión."));
    }
    exit();
}
?>

