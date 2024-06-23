<?php
session_start();
include '../../config.php';
include '../../models/Http.php';
if (isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
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
            <div class="title">
                <h1>Agregar Producto</h1>
            </div>
            <div class="con1">
                <div class="con1-1">
                </div>
                <div class="con1-2">
                    <label for="" class="label">Proveedor</label>
                    <?php
                    HttpClient::setUrl(URL . '/proveedores');
                    $resultados = HttpClient::get();
                    $resultados = $resultados['proveedores'];
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
                    HttpClient::setUrl(URL . '/marcas');
                    $rows = HttpClient::get();
                    ?>
                    <div class="select is-primary" id="select" name="marca">
                        <select name="marca" id="marca">
                            <option value="0">Seleccione una marca</option>
                            <?php
                            foreach ($rows as $row) {
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
                    HttpClient::setUrl(URL . '/categorias');
                    ?>
                    <div class="select is-primary" id="select" name="categoria">
                        <select name="categoria" id="categoria">
                            <option value="0">Seleccione una categoria</option>
                            <?php
                            $rows2 = HttpClient::get();
                            foreach ($rows2 as $row) {
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
                    <input class="input is-primary" type="text" name="imagen">
                </div>
            </div>
            <div class="butcon">
                <button class="button is-success" type="submit">Agregar</button>
            </div>


            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $required_fields = ['proveedor', 'nombre', 'descripcion', 'contenido', 'precio', 'marca', 'categoria', 'stock', 'imagen'];
                foreach ($required_fields as $field) {
                    if (!isset($_POST[$field]) || empty($_POST[$field])) {
                        echo '<div class="notification is-danger">';
                        echo '<button class="delete"></button>';
                        echo '¡Error! El campo ' . $field . ' es obligatorio.';
                        echo '</div>';
                        exit;
                    }
                }
                $proveedor = $_POST['proveedor'];
                $nombreproducto = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $contenido = $_POST['contenido'];
                $precio = $_POST['precio'];
                $marca = $_POST['marca'];
                $categoria = $_POST['categoria'];
                $stock = $_POST['stock'];
                $imagen = $_POST['imagen'];

                if (!isset($_SESSION['id_admin']) || empty($_SESSION['id_admin'])) {
                    echo '<div class="notification is-danger">';
                    echo '<button class="delete"></button>';
                    echo '¡Error! No se encontró el id del administrador.';
                    echo '</div>';
                    exit;
                }

                $producto_data = array(
                    "proveedor" => $proveedor,
                    "nombre" => $nombreproducto,
                    "descripcion" => $descripcion,
                    "contenido" => $contenido,
                    "precio" => $precio,
                    "marca" => $marca,
                    "categoria" => $categoria,
                    "stock" => $stock,
                    "imagen" => $imagen,
                    'admin' => $token
                );

                HttpClient::setUrl(URL . '/producto/create');
                HttpClient::setBody($producto_data);
                $responseData = HttpClient::post();

                if (isset($responseData['status']) && $responseData['status']) {
                    echo '<div class="notification is-success">';
                    echo '<button class="delete"></button>';
                    echo '¡Producto insertado correctamente!';
                    echo '<a href="./productos.php">Volver</a>';
                    echo '</div>';
                } else {
                    echo '<div class="notification is-danger">';
                    echo '<button class="delete"></button>';
                    echo '¡Error al insertar el producto!';
                    if (isset($responseData['message'])) {
                        echo ' ' . htmlspecialchars($responseData['message']);
                    }
                    echo '</div>';
                }
            }
            ?>

    </div>
    </form>
</body>

</html>