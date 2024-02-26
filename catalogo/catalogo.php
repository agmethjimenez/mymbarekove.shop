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
<?php include_once("header.php"); 
echo json_encode($_SESSION['carrito']) ;

if (isset($_SESSION['carrito'])) {
    $productos = $_SESSION['carrito'];

    echo "<ul>";
    foreach ($productos as $producto) {
        echo "<li>" . $producto['nombre'] . " (" . $producto['cantidad'] . " unidades) - Precio: $" . $producto['precio'] . "</li>";
    }
    echo "</ul>";
}
?>
<body>
<div class="title1">
    <h1>Todo lo que necesitas</h1>
    <p></p>
  </div>
  <div class="pri">
  <aside>
    <nav>
      
      <ul>
      <li><a id="categoria-todos">Todo</a></li>
        <li><a id="categoria-aseo">Aseo</a></li>
        <li><a id="categoria-alimento">Alimento</a></li>
        <li><a id="categoria-juguetes">Juguetes</a></li>
        <li><a id="categoria-medicamentos">Medicamentos</a></li>
        <li><a id="categoria-accesorios">Accesoriso</a></li>
        <li><a id="categoria-higiene">Higiene y cuidado</a></li>
      </ul>
    </nav>
  </aside>
<div class="main" style="width: 85%;">
 
  <div class="contenedor" name="contenedor" id="contenedor">
  <?php 
    /*$producto = new Producto();

    $producto->verProducto();*/
    ?>


  </div>
  </div>
  </div>
  <div id="modal" class="modal">
  </div>
  </div>
  <div id="panel" class="panel">
    <div class="panel-header">
      <h1 class="label">Panel Administrador</h1>
      <span id="cerrar-panel"></span>
    </div>
    <a href="../admin/crud_produ/productos.php" class="button is-link">Administrar Productos</a>
    <a href="../admin/pedidos/pedidos.php" class="button is-link">Administrar Pedidos</a>
    <a href="../admin/crud_provedores/provedores.php" class="button is-link">Administrar Proveedores</a>
    <a href="../admin/crud_users/crud.php" class="button is-link">Administrar Usuarios</a>
    <a href="../admin/admin_action/registro.php" class="button is-link">Administrar Administradores</a>
  </div>
  <?php include_once 'footer.php' ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="carrito.js"></script>
<script src="./js/getproducts.js"></script>
<script src="./js/guardarcarrito.js"></script>
<script>
  document.getElementById("abrir-panel").addEventListener("click",function(){
    document.getElementById("panel").style.display = "flex";

  })
</script>
</html>