<?php
include '../../models/Http.php';
include '../../config.php';
include '../../config/notification.php';
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();
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
if (isset($_GET['success']) && $_GET['success']) {
    mostrarNotificacion("Desactivado correctamente","success");
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
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color:white;">
        <h1>Proveedores</h1>

    </div>
    <div class="tata">
        <table class="table is-bordered">
            <thead>
                <tr>
                    <th><a class="button is-warning" href="../admin_action/panel.php">Volver</a>
                    </th>
                    <th colspan="4">
                        <form action="" method="get">
                            <input class="input is-link is-rounded" name="nm" type="search" placeholder="Buscar un proveeedor">
                        </form>
                    </th>
                    <th>
                    <a href="create.php" class="button is-primary">+</a>

                    </th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
               $url = URL.'/controller/proveedor';
               if(isset($_GET['nm'])){
                $url .= "?nm=" . $_GET['nm'];

               }
               $proveedores = HttpRequest::get($url,[
                'token: Bearer '.$_ENV['PROVEDOR_GET'].''
               ]);
               $proveedores = json_decode($proveedores,true);

                if (!empty($proveedores)){
                    foreach ($proveedores as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["idProveedor"] . "</td>";
                        echo "<td>" . $row["nombreP"] . "</td>";
                        echo "<td>" . $row["ciudad"] . "</td>";
                        echo "<td>" . $row["correo"] . "</td>";
                        echo "<td>" . $row["telefono"] . "</td>";
                        echo '<td><a href="update.php?id=' . $row["idProveedor"] . '" class="button is-link">Editar</a> <a href="delete.php?id=' . $row["idProveedor"] . '" class="button is-danger">Desactivar</a></td>';

                        echo "</tr>";
                    }
                } else {
                    ?>
                    <tr><td colspan="10">
                        No se encontraron proveedores.
                        <br>
                        <a href="./provedores.php">Reestablecer</a>

                    </td></tr>
                    <?php
                    //echo "<tr><td colspan='10'>No se encontraron proveedores.<br>
                    //<a href=''>Refresar</a></td></tr>";
                }

                ?>
            </tbody>
        </table>
    </div>

</body>

</html>