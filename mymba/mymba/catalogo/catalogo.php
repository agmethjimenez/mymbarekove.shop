<?php
require_once("../database/conexion.php");
require_once("../models/Productos.php");
$conexion->set_charset("utf8");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogo mymba</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="./css/estilo.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>
<?php include_once("header.php"); ?>
<body>

  <div class="title1">
    <h1>Productos</h1>
    <p></p>
  </div>
  <div class="contenedor" name="contenedor" id="contenedor">
    <?php 
    $producto = new Producto();

    $producto->verProducto();
    ?>


  </div>
  <div id="modal" class="modal">
  </div>
  </div>
  <div class="footer">
    <div class="col-1">
      <h3>ENLACES</h3>
      <a href="#">Acerca de</a>
      <a href="#">Servicios</a>
      <a href="#">Tienda</a>
    </div>
    <div class="col-2">
      <h3>LO ULTIMO</h3>
      <form action="">
        <input type="text" class="text" placeholder="Ingrese su correo"><br>
        <button type="submit" class="submit">Suscribirse</button>
      </form>
    </div>
    <div class="col-3">
      <h3>CONTACTO</h3>
      <p>3124376338 <br>rekovesistem@mail.com</p>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="carrito.js"></script>
<script src="modal.js"></script>

</html>