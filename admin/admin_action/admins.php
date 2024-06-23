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
                    <th colspan="2">
                        <form action="" method="get">
                        <input type="search" name="idmn" class="input is-primary is-rounded" placeholder="Buscars">
                        </form>
                    </th>
                    <th><a href="registro.php" class="button is-primary">Insertar nuevo</a></th>
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
                HttpClient::setUrl(URL.'/admin/all');
                $rows = HttpClient::get();
                
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo '<td><a href="updateadmin.php?id=' . $row["token"] . '" class="button is-link">Editar</a> <a href="deleteadmin.php?id=' . $row["id"] . '" class="button is-danger">Desactivar</a></td>';
                        echo "</tr>";
                    }        
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>