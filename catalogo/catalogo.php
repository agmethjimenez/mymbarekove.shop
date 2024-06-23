<?php
session_start();
require '../config.php';
require '../models/Http.php';
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
<?php include_once("header.php");

if (isset($_SESSION['carrito'])) {
  $productos = $_SESSION['carrito'];
}
?>
<style>
  body {
    /*background: linear-gradient(135deg, #caa678, #f5f5f5 );*/
    background-color: #e7c6b2;

  }
  .title1{
    justify-content: center ;
    display: flex;
  }
  .title1 h1{
    font-size: 35px;
  }
</style>

<body>
  <div class="title1">
    <h1>Todo lo que necesitas</h1>
  </div>
  <div class="pri">
    <aside>
      <nav>

        <ul>
          <li><a href="catalogo.php" id="categoria-todos">Todo</a></li>
          <li><a href="catalogo.php?ct=1" id="categoria-aseo">Aseo</a></li>
          <li><a href="catalogo.php?ct=2" id="categoria-alimento">Alimento</a></li>
          <li><a href="catalogo.php?ct=3" id="categoria-juguetes">Juguetes</a></li>
          <li><a href="catalogo.php?ct=4" id="categoria-medicamentos">Medicamentos</a></li>
          <li><a href="catalogo.php?ct=5" id="categoria-accesorios">Accesoriso</a></li>
          <li><a href="catalogo.php?ct=6" id="categoria-higiene">Higiene y cuidado</a></li>
        </ul>
      </nav>
    </aside>
    <div class="main" style="width: 85%;">

      <div class="contenedor" name="contenedor" id="contenedor">
        <?php
        $url = URL.'/productos/read';

        $busqueda = isset($_GET['nm']) ? $_GET['nm'] : '';
        $categoria = isset($_GET['ct']) ? $_GET['ct'] : '';

        if (!empty($busqueda) || !empty($categoria)) {
          $url .= '?';
          if (!empty($busqueda)) {
            $url .= 'nm=' . urlencode($busqueda);
          }
          if (!empty($categoria)) {
            $url .= '&ct=' . urlencode($categoria);
          }
        }

        HttpClient::setUrl($url);

        $productos = HttpClient::get();

        if(!empty($productos)){
          foreach ($productos as $producto) {
            echo '<div class="producto">';
            echo '<a href="../catalogo/producto.php?producto=' . $producto['idProducto'] . '"><img src="' . $producto['imagen'] . '" alt=""></a>';
            echo '<div class="informacion">';
            echo '<a id="nombreproducto" href="../catalogo/producto.php?producto=' . $producto['idProducto'] . '">' . $producto['nombre'] . '</a>';
            echo '<p class="precio">$' . $producto['precio'] . '</p>';
            echo '<button class="comprar" onclick="agregarAlCarrito(\'' . $producto['nombre'] . '\',' . $producto['precio'] . ',\'' . $producto['idProducto'] . '\',1,\'' . $producto['imagen'] . '\',' . $producto['cantidadDisponible'] . ')">Agregar <i class="fa-solid fa-cart-plus fa-lg"></i></button>';
            echo '</div></div>';
          }
        }else{
            echo 'Productos no disponibles';
        }
        
        ?>
      </div>
    </div>
  </div>
  <div id="modal" class="modal">
  </div>
  </div>
  <?php include_once 'footer.php' ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="carrito.js"></script>
<script src="js/guardarcarrito.js"></script>
</html>