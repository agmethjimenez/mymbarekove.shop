<?php
require '../../config.php';
require '../../models/Http.php';
require '../../config/notification.php';
session_start();
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();
if (!isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['email'], $_SESSION['token'])) {
    header("Location: ../../catalogo/login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombrePorve = $_POST['nombre'];
    $ciudadPorve = $_POST['ciudad'];
    $correoPorve = $_POST['correo'];
    $telefonoPorve = $_POST['telefono'];

    $proveedorData = array(
        "nombre" => $nombrePorve,
        "ciudad" => $ciudadPorve,
        "correo" => $correoPorve,
        "telefono" => $telefonoPorve
    );

    $response = HttpRequest::post(URL.'/controller/proveedor',$proveedorData,[
        'token: Bearer '.$_ENV['PROVEDOR_POST']
    ]);
    $response = json_decode($response,true);

    if ($response['status']) {
        mostrarNotificacion($response['mensaje'],"success");
    } else {
        mostrarNotificacion($response['mensaje'],"danger");
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
    <link rel="stylesheet" href="./estilos.css/update.css">
    <title>Document</title>
</head>
<body>
<div class="contenedor">
    <form action="create.php" method="post">
        <a href="./provedores.php"><strong>Volver</strong></a>
        <div class="title"><h1>Agregar Proveedor</h1></div>
        <div class="con1">
            <div class="con1-2">
                <label for="" class="label">Nombre</label>
                <input class="input is-primary" type="text" name="nombre">
            </div>
        </div>
        <div class="con2">
            <div class="con2-1">
                <label for="" class="label">Ciudad</label>
                <input class="input is-primary" type="text" name="ciudad">
            </div>
            <div class="con2-2">
                <label for="" class="label">Correo</label>
                <input class="input is-primary" type="text" name="correo">
            </div>
        </div>
        <div class="con3">
            <div class="con3-1">
                <label for="" class="label">Telefono</label>
                <input class="input is-primary" type="text" name="telefono">
            </div>
        </div>
        <div class="butcon">
            <button class="button is-success" type="submit">Agregar</button>
        </div>
    </form>
</div>
</body>
</html>
