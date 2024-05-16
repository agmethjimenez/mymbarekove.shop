<?php
if (isset($_GET['success']) && $_GET['success']) {
    echo '<script>alert("Desactivado correctamente")</script>';
}
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
    <title>Usuarios</title>
</head>

<body>
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color:white;">
        <h1>Usuarios</h1>
    </div>
    <div class="tata">
        <table class="table is-bordered">
            <thead>
                <tr>
                    <th>
                        <a class="button is-warning" href="../admin_action/panel.php"><i class="fa-solid fa-circle-left fa-lg"></i></a>
                    </th>
                    <form action="" method="get">
                        <th colspan="6">

                            <input type="search" name="name" class="input is-link is-rounded" placeholder="Ingrese un nombre, apellido, telefono o email a buscar">

                        </th>
                        <th colspan="2">
                            <div class="select is-link is-rounded">
                                <select name="type" class="select is-primary" id="">
                                    <option value="0">Seleccione un tipo de id</option>
                                    <option value="1">Cedula de Ciudadania</option>
                                    <option value="2">Cedula de Extranjeria</option>
                                    <option value="3">Pasaporte</option>
                                    <option value="4">Permiso Especial de Permanencia</option>
                                </select>
                            </div>
                        </th>


                        <th>
                            <button type="submit" class="button is-link"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <a href="create.php" class="button is-primary"><i class="fa-solid fa-user-plus fa-lg" style="color: #050505;"></i></a>
                        </th>
                    </form>
                </tr>
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

                $sql = "SELECT c.id, tp.id AS tipo_id, c.identificacion, c.primerNombre, c.segundoNombre, c.primerApellido, c.segundoApellido, c.telefono, c.email 
        FROM usuarios AS c 
        LEFT JOIN tiposid AS tp ON tp.codId = c.tipoId
        WHERE c.activo = 1";

                $parameters = [];

                if (isset($_GET['name']) && !empty($_GET['name'])) {
                    $name = '%' . $_GET['name'] . '%';

                    $sql .= " AND (
        c.primerNombre LIKE :name OR 
        c.segundoNombre LIKE :name OR 
        c.primerApellido LIKE :name OR
        c.segundoApellido LIKE :name OR
        c.email LIKE :name OR
        c.telefono LIKE :name
    )";

                    $parameters[':name'] = $name;
                }

                if (isset($_GET['type']) && is_numeric($_GET['type'])) {
                    $tipoId = $_GET['type'];

                    if ($tipoId != 0) {
                        $sql .= " AND c.tipoId = :tipoId";
                        $parameters[':tipoId'] = $tipoId;
                    }
                }

                $result = $conexion->prepare($sql);
                $result->execute($parameters);

                $usuarios = $result->fetchAll(PDO::FETCH_ASSOC);

                foreach ($usuarios as $row) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["tipo_id"] . '</td>';
                    echo '<td>' . $row["identificacion"] . '</td>';
                    echo '<td>' . $row["primerNombre"] . '</td>';
                    echo '<td>' . $row["segundoNombre"] . '</td>';
                    echo '<td>' . $row["primerApellido"] . '</td>';
                    echo '<td>' . $row["segundoApellido"] . '</td>';
                    echo '<td>' . $row["email"] . '</td>';
                    echo '<td>' . $row["telefono"] . '</td>';
                    echo '<td><a href="update.php?id=' . $row["id"] . '" class="button is-link">Editar</a> <a href="delete.php?id=' . $row["id"] . '" class="button is-danger">Eliminar</a></td>';
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
    </div>

</body>

</html>