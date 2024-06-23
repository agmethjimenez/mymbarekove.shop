<?php
session_start();
include '../../config.php';
include '../../models/Http.php';
if (!isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
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

    HttpClient::setUrl(URL.'/proveedores');
    HttpClient::setBody($proveedorData);
    $response = HttpClient::post();

    if ($response['status']) {
        echo '<script>alert("Proveedor registrado")</script>';
        header("Location: provedores.php");
    } else {
        echo '<script>alert("Error al registrar el proveedor")</script>';
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
    <title>Crear Proveedor</title>
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
