<?php
include '../database/conexion.php';
include '../models/Productos.php';

$database = new Database;
$conexion = $database->connect();

$resultado = "";
if(isset($_GET['producto'])){
    $nombreProducto = $_GET['producto'];
    
    // Buscar productos por nombre utilizando la función BuscarProducto de la clase Productos
    $resultado = Producto::BuscarProducto($conexion, $nombreProducto);

    // Decodificar el JSON obtenido en un array asociativo
    $resultado = json_decode($resultado, true);
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./css/estilo.css">
    <title><?php echo $nombreProducto?></title>
</head>
<body>
<style>
  
  body{
    /*background: linear-gradient(135deg, #caa678, #f5f5f5 );*/
    background-color: #e7c6b2;
    height: 100vh;
    overflow-y: auto;

  }
  #contenedor{
    margin-bottom: 40px;
  }
  
</style>
<?php
include 'header.php';
// Verificar si se encontró algún producto
if (!empty($resultado)) {
    ?>
    <div class="title1">
    <h1>Resultados de busqueda: <?php echo $nombreProducto?></h1>
    <p></p>
  </div>
    <div class="contenedor" id="contenedor">
        <?php
        foreach ($resultado as $producto) {
            ?>
            <div class="producto">
                <a href="../catalogo/producto.php?producto=<?php echo $producto['idProducto']; ?>">
                    <img src="<?php echo $producto['imagen']; ?>" alt="">
                </a>
                <div class="informacion">
                    <a id="nombreproducto" href="../catalogo/producto.php?producto=<?php echo $producto['idProducto']; ?>"><?php echo $producto['nombre']; ?></a>
                    <p class="precio">$<?php echo number_format($producto['precio']); ?></p>
                    <button class="comprar" onclick="agregarAlCarrito('<?php echo $producto['nombre']; ?>',<?php echo $producto['precio']; ?>,'<?php echo $producto['idProducto']; ?>',1,'<?php echo $producto['imagen']; ?>',<?php echo $producto['cantidadDisponible']; ?>)">Agregar <i class="fa-solid fa-cart-plus fa-lg"></i></button>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
} else {
    echo "<p>No se encontraron productos.</p>";
}

?>

</body>
</html>

