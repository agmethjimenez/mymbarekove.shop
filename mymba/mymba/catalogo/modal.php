<?php
require_once("../database/conexion.php");
$conexion->set_charset("utf8");

$error_message = "";

if (isset($_GET["id"])) {
    $productoId = $_GET["id"];
    $productoId = mysqli_real_escape_string($conexion, $productoId);
    
    $query = "SELECT * FROM productos WHERE idProducto = '$productoId'";
    $resultado = mysqli_query($conexion, $query);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);
        echo json_encode($producto);
    } else {
        echo json_encode(array("error" => "Producto no encontrado"));
    }
} else {
    echo json_encode(array("error" => "ID de producto no proporcionado"));
}
?>
