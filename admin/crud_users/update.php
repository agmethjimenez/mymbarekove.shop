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
    <link rel="stylesheet" href="./estilos/update.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Actualizar usuario</title>
</head>

<body>
    <div class="contenedor">
        <form action="update.php" method="post">
            <?php

            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $id = $_GET["id"];

                HttpClient::setUrl(URL . '/usuarios/' . $id);
                $row = HttpClient::get();
            }
            ?>
            <div class="title">
                <h1>Actualizar Datos</h1>
            </div>
            <div class="con1">
                <div class="con1-1">
                    <label for="" class="label">ID</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>" name="id" readonly>
                </div>
                <div class="con1-2">
                    <label for="" class="label">Identificacion</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['identificacion']) ? $row['identificacion'] : ''; ?>" name="identificacion" readonly>
                </div>
            </div>
            <div class="con2">
                <div class="con2-1">
                    <label for="" class="label">Tipo de ID</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['tipoId']) ? $row['tipoId'] : ''; ?>" name="tipoid">
                </div>
                <div class="con2-2">
                    <label for="" class="label">Primer nombre</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['primerNombre']) ? $row['primerNombre'] : ''; ?>" name="nombre1">
                </div>
            </div>
            <div class="con3">
                <div class="con3-1">
                    <label for="" class="label">Segundo nombre</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['segundoNombre']) ? $row['segundoNombre'] : ''; ?>" name="nombre2">
                </div>
                <div class="con3-2">
                    <label for="" class="label">Primer apellido</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['primerApellido']) ? $row['primerApellido'] : ''; ?>" name="apellido1">
                </div>
            </div>
            <div class="con4">
                <div class="con4-1">
                    <label for="" class="label">Segundo apellido</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['segundoApellido']) ? $row['segundoApellido'] : ''; ?>" name="apellido2">
                </div>
                <div class="con4-2">
                    <label for="" class="label">Email</label>
                    <input class="input is-primary" type="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" name="email">
                </div>
            </div>
            <div class="con5">
                <div class="con5-1">
                    <label for="" class="label">Telefono</label>
                    <input class="input is-primary" type="text" value="<?php echo isset($row['telefono']) ? $row['telefono'] : ''; ?>" name="telefono">
                </div>
            </div>
            <div class="butcon">
                <button class="button is-success" type="submit">Actualizar</button>
            </div>


            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $ida = $_POST['id'];
                $id_usuario = $_POST['identificacion'];
                $cod_id = $_POST['tipoid'];
                $primernombre = $_POST['nombre1'];
                $segundonombre = $_POST['nombre2'];
                $primerapellido = $_POST['apellido1'];
                $segundoapellido = $_POST['apellido2'];
                $email = $_POST['email'];
                $telefono = $_POST['telefono'];

                HttpClient::setUrl(URL . '/usuarios/update');
                HttpClient::setBody([
                    "id" => $ida,
                    "nombre1" => $primernombre,
                    "nombre2" => $segundonombre,
                    "apellido1" => $primerapellido,
                    "apellido2" => $segundoapellido,
                    "telefono" => $telefono,
                    "email" => $email
                ]);
                $response_data = HttpClient::put();

                if ($response_data['status']) {
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire({';
                    echo 'icon: "success",';
                    echo 'title: "Éxito",';
                    echo 'text: "' . addslashes($response_data['mensaje']) . '",';
                    echo '}).then((result) => {';
                    echo 'if (result.isConfirmed) {';
                    echo 'window.location.href = "./crud.php";';
                    echo '}';
                    echo '});';
                    echo '</script>';
                } else {
                    $error_message = $response_data['mensaje'] ?? 'No se pudo completar la solicitud';
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire({';
                    echo 'icon: "error",';
                    echo 'title: "Error",';
                    echo 'text: "Error en la actualización: ' . addslashes($error_message) . '"';
                    echo '});';
                    echo '</script>';
                }
            }
            ?>
    </div>
    </form>
</body>

</html>