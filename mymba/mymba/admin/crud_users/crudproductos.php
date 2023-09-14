<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./estilos/crud.css">
    <title>crudproductos</title>
</head>
<body>
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color:white;" >
    <h1>Productos</h1>
    <a href="create.php" class="button is-primary">Nuevo producto</a>
</div>
<div class="tata">
<table class="table is-bordered">
    <thead>
        <tr>
            <th>idProducto</th>
            <th>proovedor</th>
            <th>nombre</th>
            <th>descripcion</th>
            <th>contenido</th>
            <th>precio</th>
            <th>marca</th>
            <th>categoria</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conexion = new mysqli("localhost", "root", "", "mymba", 3306);
        $conexion->set_charset("utf8");

        $sql = "SELECT c.id, tp.id AS tipo_id, c.identificacion, c.primerNombre, c.segundoNombre, c.primerApellido, c.segundoApellido, c.telefono, c.email FROM usuarios AS c LEFT JOIN tiposid AS tp ON tp.codId = c.tipoId";
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