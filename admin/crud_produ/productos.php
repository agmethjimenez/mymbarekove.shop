<?php
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
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'true') {
        echo '<script>alert("Desactivado exitosamente");</script>';
    } else {
        echo '<script>alert("No desactivado");</script>';
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
        <a class="button is-warning" href="../admin_action/panel.php">Volver al panel</a>

        <a href="create.php" class="button is-primary">Nuevo producto</a>
    </div>
    <div class="tata">
        <table class="table" style="width: 90%;">
            <thead>
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
                require_once("../../database/conexion.php");


                $sql = "SELECT p.idProducto, pr.nombreP, p.nombre, p.descripcionP, p.contenido, p.precio, m.marca, c.descripcion,p.cantidadDisponible, p.imagen FROM productos as p 
        INNER JOIN proveedores as pr ON p.proveedor = pr.idProveedor
        INNER JOIN marcas as m ON p.marca = m.idMarca
        INNER JOIN categorias as c ON p.categoria = c.categoria
        WHERE activo = 1";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
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

                        echo '<td><img src="'. $imagenBLOB .'" alt="" width="70px"></td>';
                        echo '<td><a href="update.php?id=' . $row["idProducto"] . '" class="button is-link">Editar</a> <a href="delete.php?id=' . $row["idProducto"] . '" class="button is-danger">Desactivar</a></td>';

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No se encontraron usuarios.</td></tr>";
                }

                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>