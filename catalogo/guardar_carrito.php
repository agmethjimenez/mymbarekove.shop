<?php
session_start();

header("Access-Control-Allow-Origin: https://red-baths-ask.loca.lt");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    $datos = json_decode($jsonData, true);

    // Guardar los datos del carrito en la sesión
    $_SESSION['carrito'] = $datos['detalles'];
    // Verificar si la sesión se guardó correctamente
    if (isset($_SESSION['carrito'])) {
        // La sesión se guardó correctamente, imprimir mensaje de confirmación
        echo json_encode(array("mensaje" => "Datos del carrito recibidos y guardados correctamente en la sesión."));
    } else {
        // Ocurrió un error al guardar la sesión, imprimir mensaje de error
        echo json_encode(array("error" => "Error al guardar los datos del carrito en la sesión."));
    }
    exit();
}
?>

