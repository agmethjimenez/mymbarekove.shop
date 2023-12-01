<?php 
include_once("header.php");
include_once("../models/Productos.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="paginaproducto.css">
    <title></title>
</head>
<body>
    <main>
    <?php
    $id = $_GET['id'];
    $producto = new Producto();
    $producto->detallesProducto($id);  
    ?>
    </main>
</body>
</html>