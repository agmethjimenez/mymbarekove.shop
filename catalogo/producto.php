<?php
require '../config.php';
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); 
$dotenv->load();
include_once("../models/Productos.php");
if(isset($_GET['producto'])){
    $id = $_GET['producto'];

    
    $apiUrl = 'http://'.URL.'/controller/producto/'.$id.'';
    $ch = curl_init($apiUrl);
    $token = $_ENV['KEY_PRODUCTS'];
    $headers = array(
        'token: Bearer ' . $token
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if ($response !== false) {
        
        $producto = json_decode($response, true);
        $producto = $producto[0];

        $nombreProducto = isset($producto['nombre']) ? $producto['nombre'] : '';
        $descripcion = isset($producto['descripcion']) ? $producto['descripcion'] : '';
        $precio = isset($producto['precio']) ? $producto['precio'] : 0;
        $descripcionP = isset($producto['descripcionP']) ? $producto['descripcionP'] : '';
        $contenido = isset($producto['contenido']) ? $producto['contenido'] : '';
        $marca = isset($producto['marca']) ? $producto['marca'] : '';
        $cantidadDisponible = isset($producto['cantidadDisponible']) ? $producto['cantidadDisponible'] : 0;
        $imagen = isset($producto['imagen']) ? $producto['imagen'] : '';

include_once 'header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="./css/paginaproducto.css">
    <link rel="stylesheet" href="./css/estilo.css">


    <script src="carrito.js"></script>
    <script src="js/pago.js"></script>
    <title><?php echo $nombreProducto?></title>
</head>
<body>
    
    <main>
        <div class="imagenpro">
            <img src="<?php echo $imagen; ?>" alt="">
        </div>
        <div class="detalles">
        <div class="nombre"><h4><?php echo $nombreProducto; ?></h4></div>
            <div class="categoria"><p>Categoria: <?php echo $descripcion; ?> </p></div>
            <div class="precio"><p>Precio: $<?php echo number_format($precio, 0, ',', '.'); ?></p></div>
            <div class="descripcion"><p>Descripcion:<br> <?php echo $descripcionP; ?></p></div>
            <div class="contenido"><p>Contenido: <?php echo $contenido; ?></p></div>
            <div class="marca"><p>Marca: <?php echo $marca; ?></p></div>
            <div class="disponibles"><p>Disponible: <?php echo $cantidadDisponible; ?></p></div>
            <button class="comprar" onclick="agregarAlCarrito('<?php echo $nombreProducto; ?>', <?php echo $precio; ?>, '<?php echo $id; ?>', 1, '<?php echo $imagen; ?>')">Agregar al carrito <i class="fa-solid fa-cart-plus fa-lg"></i></button>
        </div>
    </main>
    <?php include_once 'footer.php'; ?>
</body>
</html>
<?php
    } else {
        echo "Error al obtener detalles del producto desde la API";
    }
}else{
    echo "Id no proporcionado";

}

?>