<?php
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
    <title>Agregar Producto</title>
</head>

<body>
    <div class="contenedor">
        <form action="create.php" method="post" enctype="multipart/form-data">
            <?php
            require_once("../../database/conexion.php");
            $conexion->set_charset("utf8");

            ?>
            <div class="title">
                <h1>Agregar Producto</h1>
            </div>
            <div class="con1">
                <div class="con1-1">
                </div>
                <div class="con1-2">
                    <label for="" class="label">Proveedor</label>
                    <?php
                    $sq = "SELECT*FROM proveedores";
                    $resul = $conexion->query($sq);

                    ?>
                    <div class="select is-primary" id="select" name="tipoid">
                        <select name="proveedor" id="proveedor">
                            <option value="0">Seleccione un proveedor</option>
                            <?php
                            while ($row = $resul->fetch_assoc()) {
                                $idpro = $row['idProveedor'];
                                $namepro = $row['nombreP'];
                                echo "<option value=\"$idpro\">$namepro</option>";
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
                    $resul = $conexion->query($sqe);

                    ?>
                    <div class="select is-primary" id="select" name="marca">
                        <select name="marca" id="marca">
                            <option value="0">Seleccione una marca</option>
                            <?php
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
                    <?php
                    $sqe = "SELECT*FROM categorias";
                    $resul = $conexion->query($sqe);
                    ?>
                    <div class="select is-primary" id="select" name="categoria">
                        <select name="categoria" id="categoria">
                            <option value="0">Seleccione una categoria</option>
                            <?php
                            while ($row = $resul->fetch_assoc()) {
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
        "imagen" => $direccionimg
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/mymbarekove.shop/controller/producto',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($producto_data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$_ENV['POST_PRODUCT'].' ',
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $responseData = json_decode($response, true);

    if (isset($responseData['exito']) && $responseData['exito']) {
        echo '<div class="notification is-success">';
        echo '<button class="delete"></button>';
        echo '¡Producto insertado correctamente!';
        echo '<a href="./productos.php">Volver</a>';
        echo '</div>';
    }else{
        echo '<div class="notification is-danger">';
        echo '<button class="delete"></button>';
        echo '¡Error! ' . $responseData['error'];
        echo '</div>';
    }
}
?>
    </div>
    </form>
</body>

</html>