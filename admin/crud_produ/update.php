<?Php 
session_start();
if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['email'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit; 
}
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./estyles/norm.css">
    <title>Actualizar Producto</title>
</head>
<body>
<div class="contenedor">
    <form action="update.php" method="post" enctype="multipart/form-data">
    <?php
require_once("../../database/conexion.php");
if($_SERVER["REQUEST_METHOD"] === "GET"){
$id = $_GET["id"];
$sql = "SELECT*FROM productos WHERE idProducto = '$id' ";
$result = $conexion->query($sql);

if ($result) {
    $roe = $result->fetch_assoc();
}}
?>
    <div class="title" ><h1>Actualizar Producto </h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['idProducto']) ? $roe['idProducto'] : ''; ?>" name="id" readonly>
        </div>
        <div class="con1-2">
        <label for="" class="label">Proveedor</label>
        <div class="select is-primary">
            <select name="proveedor" id="proveedor">
            <?php 
                $marcquey = "SELECT p.idProducto,pr.idProveedor as idprovedor, pr.nombreP FROM productos AS p INNER JOIN proveedores as pr ON p.proveedor = pr.idProveedor WHERE p.idProducto = '$id'";
                $resulmarca = $conexion->query($marcquey);
                            while ($row = $resulmarca->fetch_assoc()) {
                                $idmarca = $row['idprovedor'];
                                $namemarca = $row['nombreP'];
                                echo "<option value=\"$idmarca\">$namemarca</option>";
                            }
                            $sqe = "SELECT*FROM proveedores";
                            $resul = $conexion->query($sqe);
                            while ($row = $resul->fetch_assoc()) {
                                $idmar = $row['idProveedor'];
                                $namemar = $row['nombreP'];
                                echo "<option value=\"$idmar\">$namemar</option>";
                            }               
            ?>
            </select>
        
        </div>
        </div>   
    </div>
        <div class="con2">
        <div class="con2-1">
        <label for="" class="label">Nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['nombre']) ? $roe['nombre'] : ''; ?>" name="nombre">
        <label for="" class="label">Stock</label>
        <input type="number" class="input is-primary" value="<?php echo isset($roe['cantidadDisponible']) ? $roe['cantidadDisponible'] : ''; ?>" name="stock">
        </div> 
            <div class="con2-2">
        <label for="" class="label">Descripcion</label>
        <textarea class="textarea is-primary" type="text" id="descripcion" value="" name="descripcion"><?php echo isset($roe['descripcionP']) ? $roe['descripcionP'] : ''; ?></textarea>
        </div>
        
        </div>
        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Contenido</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['contenido']) ? $roe['contenido'] : ''; ?>" name="contenido">
        </div>
            <div class="con3-2">
        <label for="" class="label">Precio</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['precio']) ? $roe['precio'] : ''; ?>" name="precio">
        </div>  
    </div>
    <div class="con4">
        <div class="con4-1">      
            <label for="" class="label">Marca</label>
            <div class="select is-primary">
                <select name="marca" id="marca">
                <?php 
                $marcquey = "SELECT p.idProducto,m.idMarca, m.marca FROM productos AS p INNER JOIN marcas as m ON p.marca = m.idMarca WHERE p.idProducto = '$id'";
                $resulmarca = $conexion->query($marcquey);
                            while ($row = $resulmarca->fetch_assoc()) {
                                $idmarca = $row['idMarca'];
                                $namemarca = $row['marca'];
                                echo "<option value=\"$idmarca\">$namemarca</option>";
                            }
                            $sqe = "SELECT*FROM marcas";
                            $resul = $conexion->query($sqe);
                            while ($row = $resul->fetch_assoc()) {
                                $idmar = $row['idMarca'];
                                $namemar = $row['marca'];
                                echo "<option value=\"$idmar\">$namemar</option>";
                            }
        
                            
            ?>
                </select>

            </div>
        </div>
        <div class="con4-2">
            <label for="" class="label">Categoria</label>
            <div class="select is-primary">
                <select name="categoria" id="categoria">
                <?php 
                $marcquey = "SELECT p.idProducto,c.categoria as idcategoria, c.descripcion as categoria FROM productos AS p INNER JOIN categorias as c ON p.categoria = c.categoria WHERE p.idProducto = '$id'";
                $resulmarca = $conexion->query($marcquey);
                            while ($row = $resulmarca->fetch_assoc()) {
                                $idmarca = $row['idcategoria'];
                                $namemarca = $row['categoria'];
                                echo "<option value=\"$idmarca\">$namemarca</option>";
                            }
                            $sqe = "SELECT*FROM categorias";
                            $resul = $conexion->query($sqe);
                            while ($row = $resul->fetch_assoc()) {
                                $idmar = $row['categoria'];
                                $namemar = $row['descripcion'];
                                echo "<option value=\"$idmar\">$namemar</option>";
                            }
        
                            
            ?>
                </select>
            </div>
        </div>
    </div>
    <div class="con5">
        <label for="" class="label">Imagen</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['imagen']) ? $roe['imagen'] : ''; ?>" name="direccion">

        <?php $imagenBLOB = isset($roe["imagen"]) ? $roe['imagen']:'';
        echo '<img src="' .$imagenBLOB. '" alt="Imagen de Producto" width="200px">';
                ?>
    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Actualizar</button>
    </div>
    

    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ida = $_POST['id'];
    $proveedor = $_POST['proveedor'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contenido = $_POST['contenido'];
    $precio = $_POST['precio'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $imagen = $_POST['direccion'];

    // Realizar la solicitud cURL para actualizar el producto en la otra aplicación
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/mymbarekove.shop/controller/producto',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => '{
            "idProducto": ' . $ida . ',
            "nombre": "' . $nombre . '",
            "descripcionP": "' . $descripcion . '",
            "contenido": "' . $contenido . '",
            "precio": "' . $precio . '",
            "descripcion": "' . $marca . '",
            "cantidadDisponible": ' . $stock . ',
            "imagen": "' . $imagen . '"
        }',
        CURLOPT_HTTPHEADER => array(
            'token: Bearer '.$_ENV['PUT_PRODUCT'].'',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    // Verificar la respuesta de la solicitud cURL
    if ($response !== false) {
        $responseData = json_decode($response, true);
        if (isset($responseData['status']) && $responseData['status'] === true) {
            echo '<div class="notification is-success">';
            echo '<button class="delete"></button>';
            echo '¡Producto actualizado correctamente';
            echo '<br><a href="./productos.php">Volver</a>';
            echo '</div>';
        } else {
            echo '<div class="notification is-danger">';
            echo '<button class="delete"></button>';
            echo 'Error al actualizar el producto en la otra aplicación: ' . $responseData['mensaje'];
            echo '</div>';
        }
    } else {
        echo '<div class="notification is-danger">';
        echo '<button class="delete"></button>';
        echo 'Error al realizar la solicitud cURL para actualizar el producto en la otra aplicación';
        echo '</div>';
    }
}
?>



    </div>
    </form>
    </body>
</html>