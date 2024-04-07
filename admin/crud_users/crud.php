<?php
if(isset($_GET['success']) && $_GET['success'] ){
    echo '<script>alert("Desactivado correctamente")</script>';
}else{

}
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
    <link rel="stylesheet" href="./estilos/crud.css">
    <title>CRUD</title>
</head>
<body>
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color:white;" >
    <h1>Usuarios</h1>
    <a href="create.php" class="button is-primary">Nuevo usuario</a>
</div>
<div class="tata">
<table class="table is-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo ID</th>
            <th>Identificacion</th>
            <th>Primer nombre</th>
            <th>Segundo nombre</th>
            <th>Primer apellido</th>
            <th>Segundo apellido</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require '../../database/conexion.php';
        $database = new Database;
        $conexion = $database->connect();

        $sql = "SELECT c.id, tp.id AS tipo_id, c.identificacion, c.primerNombre, c.segundoNombre, c.primerApellido, c.segundoApellido, c.telefono, c.email FROM usuarios AS c 
        LEFT JOIN tiposid AS tp ON tp.codId = c.tipoId
        WHERE c.activo = 1";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["tipo_id"] . "</td>";
                echo "<td>" . $row["identificacion"] . "</td>";
                echo "<td>" . $row["primerNombre"] . "</td>";
                echo "<td>" . $row["segundoNombre"] . "</td>";
                echo "<td>" . $row["primerApellido"] . "</td>";
                echo "<td>" . $row["segundoApellido"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo '<td><a href="update.php?id='. $row["id"] .'" class="button is-link">Editar</a> <a href="delete.php?id='. $row["id"] .'" class="button is-danger">Eliminar</a></td>';

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