<?php
require '../../config.php';
require '../../database/conexion.php';

$database = new Database;
$conexion = $database->connect();
session_start();
if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['email'], $_SESSION['token'])) {
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
    <link rel="stylesheet" href="./estilos.css/update.css">
    <title>Document</title>
</head>
<body>
<div class="contenedor">
    <form action="update.php" method="post">
    <?php

if($_SERVER["REQUEST_METHOD"] === "GET"){
$id = $_GET["id"];
$sql = "SELECT * FROM proveedores WHERE idProveedor = '$id'";
$result = $conexion->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
}}
?>
    <div class="title" ><h1>Actualizar Proveedor</h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['idProveedor']) ? $row['idProveedor'] : ''; ?>" name="id" readonly>
        </div>
        <div class="con1-2">
        <label for="" class="label">Nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['nombreP']) ? $row['nombreP'] : ''; ?>" name="nombre">
        </div>   
    </div>
        <div class="con2">
        <div class="con2-1">
        <label for="" class="label">Ciudad</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['ciudad']) ? $row['ciudad'] : ''; ?>" name="ciudad">
        </div> 
            <div class="con2-2">
        <label for="" class="label">Correo</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['correo']) ? $row['correo'] : ''; ?>" name="correo">
        </div>
        
        </div>
        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Telefono</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['telefono']) ? $row['telefono'] : ''; ?>" name="telefono">
        </div>
            <div class="con3-2">
        <label for="" class="label">Estado</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['estado']) ? $row['estado'] : ''; ?>" name="estado" readonly>
        </div>  
    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Actualizar</button>
    </div>
    </form>
    </div>

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $ida = $_POST['id'];
    $nombreProveedor = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.URL.'/controller/proveedor',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS =>'{
            "idProveedor": '.$ida.',
            "nombreP": "'.$nombreProveedor.'",
            "ciudad": "'.$ciudad.'",
            "correo": "'.$correo.'",
            "telefono": "'.$telefono.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer glNXMgjPLVbBPf5zUUfeI1nFOCjhwa4TDdYXWWyvGMHdSbtUtBY6M6Ow6uaoXVs9S1TBrdhysLnUgea0z1Tds32oM65mrXCT7d7FoSDBVjcXtd1kDat',
            'Content-Type: application/json',
            'Cookie: PHPSESSID=u8715ej4gmj7teu6hegneotmcr'
        ),
    ));

    $response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if($http_status == 200){
        echo '<script>alert(Actualizado con exito!)</script>';
        header("Location: provedores.php");
        exit;
    } else {
        echo "Error en la actualización. Código de estado: " . $http_status;
    }

    curl_close($curl);
}
?>
</body>
</html>
