<?php
require_once '../../models/Categoria.php';
require_once '../../models/Proveedor.php';
require_once '../../config/notification.php';
require_once("../../database/conexion.php");
$database = new Database;
$conexion = $database->connect();
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
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'true') {
        mostrarNotificacion("Desactivado exitosamente","success");
    } else {
        mostrarNotificacion("No desactivado","danger");
    }
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
    <link rel="stylesheet" href="./estyles/cri.css">
    <title>CRUD</title>
</head>

<body>
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color:white;">
        <h1>Productos</h1>
    </div>
    <div class="tata">
        <table class="table" style="width: 90%;">
            <thead>
                <tr>
                    <th><a class="button is-warning" href="../admin_action/panel.php"><i class="fa-solid fa-circle-left"></i></a></th>
                    <form action="" method="get">
                        <th colspan="2">
                            <input type="text" name="id" class="input is-link is-rounded" placeholder="Filtrar por id">
                        </th>
                        <th colspan="5">
                            <input type="search" name="name" class="input is-link is-rounded" placeholder="Ingrese el nombre del producto a buscar">
                        </th>
                        <th colspan="2">
                            <div class="select is-link is-rounded">
                                <select name="category" id="">
                                    <option value="0" selected>Selecciona categoria</option>
                                    <?php
                                    $categorias = Categoria::getCategorias($conexion);
                                    foreach ($categorias as $categoria) {
                                    ?>
                                        <option value="<?php echo $categoria['categoria'] ?>"><?php echo $categoria['descripcion'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </th>

                        <th style="display: flex;">
                            <button type="submit" class="button is-link"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    <a href="create.php" class="button is-primary"><i class="fa-solid fa-circle-plus"></i></a>

                    </th>

                </tr>

                <tr>
                    <th>ID</th>
                    <th>Proveedor</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Contenido</th>
                    <th>Precio</th>
                    <th>Marca</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../../models/Productos.php';

                $producto = new Producto;
                $productos = $producto->GetProductos($conexion);

                if (isset($_GET['name']) && !empty($_GET['name'])) {
                    $nombre = $_GET['name'];
                    $productos = $producto->GetProductos($conexion, null, $nombre);
                }

                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $categoria = $_GET['category'];
                    $productos = $producto->GetProductos($conexion, null, null, $categoria);
                }

                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $id_producto = $_GET['id'];
                    $productos = $producto->GetProductos($conexion, $id_producto);
                }

                foreach ($productos as $row) {
                    echo "<tr>";
                    echo "<td>" . $row["idProducto"] . "</td>";
                    echo "<td>" . $row["nombreP"] . "</td>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["descripcionP"] . "</td>";
                    echo "<td>" . $row["contenido"] . "</td>";
                    echo "<td> $" . $row["precio"] . "</td>";
                    echo "<td>" . $row["marca"] . "</td>";
                    echo "<td>" . $row["descripcion"] . "</td>";
                    echo "<td>" . $row["cantidadDisponible"] . "</td>";

                    $imagenBLOB = $row["imagen"];
                    echo '<td><img src="' . $imagenBLOB . '" alt="" width="70px"></td>';

                    echo '<td><a href="update.php?id=' . $row["idProducto"] . '" class="button is-link">Editar</a> <a href="delete.php?id=' . $row["idProducto"] . '" class="button is-danger">Desactivar</a></td>';
                    echo "</tr>";
                }

                if (empty($productos)) {
                    echo '<tr><td colspan="10">No hay productos</td></tr>';
                }
                ?>

            </tbody>
        </table>
    </div>

</body>

</html>