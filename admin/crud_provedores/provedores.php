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
    <link rel="stylesheet" href="./estilos.css/crud.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>CRUD</title>
</head>

<body>
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color: white;">
        <h1>Proveedores</h1>
    </div>

    <div class="tata">
        <table class="table is-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                HttpClient::setUrl(URL . '/proveedores');
                $response = HttpClient::get();
                $proveedores = $response['proveedores'] ?? [];

                if (!empty($proveedores)) {
                    foreach ($proveedores as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["idProveedor"] . "</td>";
                        echo "<td>" . $row["nombreP"] . "</td>";
                        echo "<td>" . $row["ciudad"] . "</td>";
                        echo "<td>" . $row["correo"] . "</td>";
                        echo "<td>" . $row["telefono"] . "</td>";
                        echo "<td>" . $row["estado"] . "</td>";
                        echo '<td><a href="update.php?id=' . $row["idProveedor"] . '" class="button is-link">Editar</a> <a href="delete.php?id=' . $row["idProveedor"] . '" class="button is-danger">Desactivar</a></td>';
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="7">No se encontraron proveedores.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    if (isset($_GET['success']) && $_GET['success']) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Desactivado correctamente'
                });
              </script>";
    }
    ?>
</body>
</html>
