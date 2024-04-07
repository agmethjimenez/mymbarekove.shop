<?php
require '../../config.php';
session_start();
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

    $jsonData = json_encode($proveedorData);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://' . URL . '/controller/proveedor',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer d0Qa2xl4rrXrFzObkcA4DPABXl1EfD7OvUWhaSN9zcKhNBdVbEptPX1qOTphEX2d4Obl588eWQ1e60uYVsiBF4q4G22PcVPjKH2B5nnDu8tuBPecHZl',
            'Content-Type: application/json',
            'Cookie: PHPSESSID=u8715ej4gmj7teu6hegneotmcr'
        ),
    ));

    $response = curl_exec($curl);

    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_status == 201) {
        echo '<script>alert("Proveedor registrado")</script>';
    } else {
        echo '<script>alert("Error al registrar el proveedor. Código de estado: ' . $http_status . '")</script>';
    }

    curl_close($curl);
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
