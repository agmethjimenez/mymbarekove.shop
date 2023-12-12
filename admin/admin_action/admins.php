<?php
include_once '../../database/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../crud_produ/estyles/cri.css">
    <title>Administradores</title>
</head>

<body>
    <div class="tata">
        <table class="table">
            <thead>
                <tr>
                    <th>Administradores</h1>
                    </th>
                    <th><input type="search" class="input"></th>
                    <th></th>
                    <th> <a href="registro.php" class="button is-primary">Nuevo administrador</a></th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $database = new Database();
                $conexion = $database->connect();
                $query = "SELECT*FROM administradores WHERE activo = 1";
                $result = $conexion->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo '<td><a href="updateadmin.php?id=' . $row["id"] . '" class="button is-link">Editar</a> <a href="deleteadmin.php?id=' . $row["id"] . '" class="button is-danger">Desactivar</a></td>';
                        echo "</tr>";
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>