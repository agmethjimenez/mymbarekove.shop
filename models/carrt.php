<?php

// Iniciar o reanudar la sesión
session_start();

// Verificar si se ha enviado un formulario para agregar un producto al carrito
if(isset($_POST['agregar_al_carrito'])) {
    // Obtener el ID y la cantidad del producto enviado por el formulario
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Añadir el producto al carrito
    if(isset($_SESSION['carrito'][$producto_id])) {
        // Si el producto ya está en el carrito, simplemente actualiza la cantidad
        $_SESSION['carrito'][$producto_id] += $cantidad;
    } else {
        // Si el producto no está en el carrito, añádelo con la cantidad especificada
        $_SESSION['carrito'][$producto_id] = $cantidad;
    }
}

// Función para calcular el total de la compra
function calcularTotal() {
    $total = 0;
    if(isset($_SESSION['carrito'])) {
        foreach($_SESSION['carrito'] as $producto_id => $cantidad) {
            // Aquí deberías obtener el precio del producto desde una base de datos
            // Por simplicidad, supongamos que cada producto tiene un precio de $10
            $precio_producto = 10;
            $total += $precio_producto * $cantidad;
        }
    }
    return $total;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de compras</title>
</head>
<body>
    <h1>Carrito de compras</h1>
    
    <form method="post" action="">
        <label for="producto_id">ID del producto:</label>
        <input type="text" name="producto_id" id="producto_id">
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" value="1" min="1">
        <input type="submit" name="agregar_al_carrito" value="Agregar al carrito">
    </form>

    <h2>Productos en el carrito:</h2>
    <ul>
        <?php
        // Mostrar los productos en el carrito
        if(isset($_SESSION['carrito'])) {
            foreach($_SESSION['carrito'] as $producto_id => $cantidad) {
                // Aquí deberías obtener los detalles del producto desde una base de datos
                // Por simplicidad, mostraremos solo el ID y la cantidad
                echo "<li>Producto ID: $producto_id - Cantidad: $cantidad</li>";
            }
        }
        ?>
    </ul>

    <h2>Total de la compra: $<?php echo calcularTotal(); ?></h2>
</body>
</html>