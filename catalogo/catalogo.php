<?php
require '../config.php';
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();
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
<?php include_once("header.php"); 

if (isset($_SESSION['carrito'])) {
    $productos = $_SESSION['carrito'];
    //echo json_encode($productos);
}
?>
<style>
  
  body{
    /*background: linear-gradient(135deg, #caa678, #f5f5f5 );*/
    background-color: #e7c6b2;

  }
</style>
<body>
<div class="title1">
    <h1>Todo lo que necesitas</h1>
    <p></p>
  </div>
  <div class="pri">
  <aside>
    <nav>
      
      <ul>
      <li><a href="http://<?php echo URL ?>/catalogo/catalogo.php" id="categoria-todos">Todo</a></li>
        <li><a href="http://<?php echo URL ?>/catalogo/catalogo.php?categoria=1" id="categoria-aseo">Aseo</a></li>
        <li><a href="http://<?php echo URL ?>/catalogo/catalogo.php?categoria=2" id="categoria-alimento">Alimento</a></li>
        <li><a href="http://<?php echo URL ?>/catalogo/catalogo.php?categoria=3" id="categoria-juguetes">Juguetes</a></li>
        <li><a href="http://<?php echo URL ?>/catalogo/catalogo.php?categoria=4" id="categoria-medicamentos">Medicamentos</a></li>
        <li><a href="http://<?php echo URL ?>/catalogo/catalogo.php?categoria=5" id="categoria-accesorios">Accesoriso</a></li>
        <li><a href="http://<?php echo URL ?>/catalogo/catalogo.php?categoria=6" id="categoria-higiene">Higiene y cuidado</a></li>
      </ul>
    </nav>
  </aside>
<div class="main" style="width: 85%;">
 
  <div class="contenedor" name="contenedor" id="contenedor">
    <?php
$url = 'http://'.URL.'/controller/producto.php';

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

if (!empty($busqueda) || !empty($categoria)) {
    $url .= '?';
    if (!empty($busqueda)) {
        $url .= 'busqueda=' . urlencode($busqueda);
    }
    if (!empty($categoria)) {
        $url .= '&categoria=' . urlencode($categoria);
    }
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'token: Bearer ' . $_ENV['KEY_PRODUCTS'] 
));

$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    die('Error en la solicitud cURL: ' . curl_error($ch));
}

$productos = json_decode($response, true);

foreach ($productos as $producto) {
    echo '<div class="producto">';
    echo '<a href="../catalogo/producto.php?producto=' . $producto['idProducto'] . '"><img src="' . $producto['imagen'] . '" alt=""></a>';
    echo '<div class="informacion">';
    echo '<a id="nombreproducto" href="../catalogo/producto.php?producto=' . $producto['idProducto'] . '">' . $producto['nombre'] . '</a>';
    echo '<p class="precio">$' . $producto['precio'] . '</p>';
    echo '<button class="comprar" onclick="agregarAlCarrito(\'' . $producto['nombre'] . '\',' . $producto['precio'] . ',\'' . $producto['idProducto'] . '\',1,\'' . $producto['imagen'] . '\',' . $producto['cantidadDisponible'] . ')">Agregar <i class="fa-solid fa-cart-plus fa-lg"></i></button>';
    echo '</div></div>';
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
<script>
  document.getElementById("abrir-panel").addEventListener("click",function(){
    document.getElementById("panel").style.display = "flex";

  })
</script>
</html>