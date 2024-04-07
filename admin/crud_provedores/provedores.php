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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./estilos.css/crud.css">
    <title>CRUD</title>
</head>
<body>
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color:white;" >
    <h1>Proveedores</h1>
    <a href="create.php" class="button is-primary">Nuevo proveedor</a>
</div>
<div class="tata">
<table class="table is-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Ciudad</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conexion = new mysqli("localhost", "root", "", "mymba2", 3306);
        $conexion->set_charset("utf8");

        $sql = "SELECT*FROM proveedores WHERE estado = 'SI'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["idProveedor"] . "</td>";
                echo "<td>" . $row["nombreP"] . "</td>";
                echo "<td>" . $row["ciudad"] . "</td>";
                echo "<td>" . $row["correo"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo "<td>" . $row["estado"] . "</td>";
                echo '<td><a href="update.php?id='. $row["idProveedor"] .'" class="button is-link">Editar</a> <a href="delete.php?id='. $row["idProveedor"] .'" class="button is-danger">Desactivar</a></td>';

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