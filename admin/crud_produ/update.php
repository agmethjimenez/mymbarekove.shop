<?php
require '../../config.php';
require '../../config/notification.php';
require '../../models/Http.php';
session_start();
if (isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['email'], $_SESSION['token'])) {
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
            <a href="./productos.php"><strong>Volver</strong></a>
            <?php
            require_once("../../database/conexion.php");
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $id = $_GET["id"];
                $sql = "SELECT*FROM productos WHERE idProducto = :id ";
                $result = $conexion->prepare($sql);
                $result->bindParam(":id", $id);
                $result->execute();

                $roe = $result->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <div class="title">
                <h1>Actualizar Producto </h1>
            </div>
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
                            $marcaQuery = "SELECT p.idProducto, pr.idProveedor AS idProveedor, pr.nombreP 
               FROM productos AS p 
               INNER JOIN proveedores AS pr ON p.proveedor = pr.idProveedor 
               WHERE p.idProducto = :idProducto";

                            $stmtMarca = $conexion->prepare($marcaQuery);
                            $stmtMarca->bindParam(':idProducto', $id);
                            $stmtMarca->execute();

                            while ($row = $stmtMarca->fetch(PDO::FETCH_ASSOC)) {
                                $idProveedor = $row['idProveedor'];
                                $nombreProveedor = $row['nombreP'];
                                echo "<option value=\"$idProveedor\">$nombreProveedor</option>";
                            }

                            $sqlProveedores = "SELECT idProveedor, nombreP FROM proveedores";

                            $stmtProveedores = $conexion->prepare($sqlProveedores);
                            $stmtProveedores->execute();

                            while ($row = $stmtProveedores->fetch(PDO::FETCH_ASSOC)) {
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
                            $marcaQuery = "SELECT p.idProducto, m.idMarca, m.marca 
               FROM productos AS p 
               INNER JOIN marcas AS m ON p.marca = m.idMarca 
               WHERE p.idProducto = :idProducto";

                            $stmtMarca = $conexion->prepare($marcaQuery);
                            $stmtMarca->bindParam(':idProducto', $id);
                            $stmtMarca->execute();

                            while ($row = $stmtMarca->fetch(PDO::FETCH_ASSOC)) {
                                $idMarca = $row['idMarca'];
                                $nombreMarca = $row['marca'];
                                echo "<option value=\"$idMarca\">$nombreMarca</option>";
                            }

                            $sqlMarcas = "SELECT idMarca, marca FROM marcas";

                            $stmtMarcas = $conexion->prepare($sqlMarcas);
                            $stmtMarcas->execute();

                            while ($row = $stmtMarcas->fetch(PDO::FETCH_ASSOC)) {
                                $idMarca = $row['idMarca'];
                                $nombreMarca = $row['marca'];
                                echo "<option value=\"$idMarca\">$nombreMarca</option>";
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
                            $categoriaQuery = "SELECT p.idProducto, c.categoria AS idcategoria, c.descripcion AS categoria 
                   FROM productos AS p 
                   INNER JOIN categorias AS c ON p.categoria = c.categoria 
                   WHERE p.idProducto = :idProducto";

                            $stmtCategoria = $conexion->prepare($categoriaQuery);
                            $stmtCategoria->bindParam(':idProducto', $id, PDO::PARAM_INT);
                            $stmtCategoria->execute();

                            while ($row = $stmtCategoria->fetch(PDO::FETCH_ASSOC)) {
                                $idCategoria = $row['idcategoria'];
                                $nombreCategoria = $row['categoria'];
                                echo "<option value=\"$idCategoria\">$nombreCategoria</option>";
                            }

                            $sqlCategorias = "SELECT categoria, descripcion FROM categorias";

                            $stmtCategorias = $conexion->prepare($sqlCategorias);
                            $stmtCategorias->execute();

                            while ($row = $stmtCategorias->fetch(PDO::FETCH_ASSOC)) {
                                $idCategoria = $row['categoria'];
                                $nombreCategoria = $row['descripcion'];
                                echo "<option value=\"$idCategoria\">$nombreCategoria</option>";
                            }
                            ?>
                            s
                        </select>
                    </div>
                </div>
            </div>
            <div class="con5">
                <label for="" class="label">Imagen</label>
                <input class="input is-primary" type="text" value="<?php echo isset($roe['imagen']) ? $roe['imagen'] : ''; ?>" name="direccion">

                <?php $imagenBLOB = isset($roe["imagen"]) ? $roe['imagen'] : '';
                echo '<img src="' . $imagenBLOB . '" alt="Imagen de Producto" width="200px">';
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

                $response = HttpRequest::put(URL . '/controller/producto',[
                    'idProducto' => $ida,
                    'nombre' => $nombre,
                    'descripcionP' => $descripcion,
                    'contenido' => $contenido,
                    'precio' => $precio,
                    'descripcion' => $marca,
                    'cantidadDisponible' => $stock,
                    'imagen' => $imagen
                ],[
                    'token: Bearer ' . $_ENV['PUT_PRODUCT'] . '',
                    'Content-Type: application/json'
                ]);

                $responseData = json_decode($response, true);
                if (isset($responseData['status']) && $responseData['status'] === true) {
                    mostrarNotificacion("Producto actualizado","success");
                } else {
                    mostrarNotificacion("Error al actualizar producto","danger");

                }
            }
            ?>



    </div>
    </form>
</body>

</html>