<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    $datos = json_decode($jsonData, true);

    $_SESSION['carrito'] = $datos['detalles'];

    $productos = $datos['detalles'];
    $mensajeAlerta = "Productos recibidos:\n";

    foreach ($productos as $producto) {
        $mensajeAlerta .= "- " . $producto['nombre'] . " (" . $producto['cantidad'] . " unidades) - Precio: $" . $producto['precio'] . "\n";
    }

    echo "<script>alert('" . $mensajeAlerta . "');</script>";
}
?>