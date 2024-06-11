<?php
include '../../config/notification.php';
include '../../config.php';
include '../../models/Http.php';
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();

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
    <title>Agregar Producto</title>
</head>

<body>
    <div class="contenedor">
        <form action="create.php" method="post" enctype="multipart/form-data">
            <?php
            require_once("../../database/conexion.php");

            ?>
            <a href="./productos.php"><strong>Volver</strong></a>
            <div class="title">
                <h1>Agregar Producto</h1>
            </div>
            <div class="con1">
                <div class="con1-1">
                </div>
                <div class="con1-2">
                    <label for="" class="label">Proveedor</label>
                    <?php
$sql = "SELECT idProveedor, nombreP FROM proveedores";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="select is-primary" id="select" name="tipoid">
    <select name="proveedor" id="proveedor">
        <option value="0">Seleccione un proveedor</option>
        <?php
        foreach ($resultados as $row) {
            $idProveedor = $row['idProveedor'];
            $nombreProveedor = $row['nombreP'];
            echo "<option value=\"$idProveedor\">$nombreProveedor</option>";
        }
        ?>
    </select>
</div>

                </div>
            </div>


            <div class="con2">
                <div class="con2-1">
                    <label for="" class="label">Nombre</label>
                    <input class="input is-primary" type="text" name="nombre">
                    <label for="" class="label">Stock</label>
                    <input class="input is-primary" type="text" name="stock">
                </div>
                <div class="con2-2">
                    <label for="" class="label">Descripcion</label>
                    <textarea class="textarea is-primary" id="textarea" type="text" name="descripcion"></textarea>
                </div>
            </div>


            <div class="con3">
                <div class="con3-1">
                    <label for="" class="label">Contenido</label>
                    <input class="input is-primary" type="text" name="contenido">
                </div>
                <div class="con3-2">
                    <label for="" class="label">Precio</label>
                    <input class="input is-primary" type="text" name="precio">
                </div>
            </div>
            <div class="con4">
                <div class="con4-1">
                    <label class="label" for="">Marca</label>

                    <?php
                    $sqe = "SELECT*FROM marcas";
                    $resul = $conexion->prepare($sqe);
                    $resul->execute();
                    $rows = $resul->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                    <div class="select is-primary" id="select" name="marca">
                        <select name="marca" id="marca">
                            <option value="0">Seleccione una marca</option>
                            <?php
                            foreach($rows as $row) {
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
                    <?php
                    $sqe = "SELECT*FROM categorias";
                    $resul = $conexion->prepare($sqe);
                    $resul->execute();
                    ?>
                    <div class="select is-primary" id="select" name="categoria">
                        <select name="categoria" id="categoria">
                            <option value="0">Seleccione una categoria</option>
                            <?php
                            $rows2 = $resul->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rows2 as $row) {
                                $idcat = $row['categoria'];
                                $namecat = $row['descripcion'];
                                echo "<option value=\"$idcat\">$namecat</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="con5">
                <div class="con5-1">
               
                    <label for="" class="label">Imagen del producto</label>
                    <input class="input is-primary" type="text" name="direccion">
                </div>
            </div>
            <div class="butcon">
                <button class="button is-success" type="submit">Agregar</button>
            </div>


<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $proveedor = $_POST['proveedor'];
    $nombreproducto = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contenido = $_POST['contenido'];
    $precio = $_POST['precio'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $direccionimg = $_POST['direccion'];
    
    $producto_data = array(
        "proveedor" => $proveedor,
        "nombre" => $nombreproducto,
        "descripcion" => $descripcion,
        "contenido" => $contenido,
        "precio" => $precio,
        "marca" => $marca,
        "categoria" => $categoria,
        "stock" => $stock,
        "imagen" => $direccionimg,
        'idadmin'=> $id_admin
    );
    echo json_encode($producto_data);

    $response = HttpRequest::post(URL.'/controller/producto',$producto_data,[
        'Content-Type: application/json',
        'token: Bearer '.$_ENV['POST_PRODUCT'].' ',
    ]);
    $response = json_decode($response,true);
    
    if ($response['status']) {
        mostrarNotificacion("Creado exitosamente","success");
    }else{
        mostrarNotificacion($responseData['error'],"danger");
    }
}
?>
    </div>
    </form>
</body>

</html>