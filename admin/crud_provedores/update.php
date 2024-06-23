<?php
session_start();
require '../../config.php';
require '../../models/Http.php';

if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
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
    <link rel="stylesheet" href="./estilos.css/update.css">
    <title>Actualizar Proveedor</title>
</head>
<body>
<div class="contenedor">
    <form action="" method="post">
    <?php
    $id = $_GET["id"];
    HttpClient::setUrl(URL.'/proveedores/'.$id);
    $row = HttpClient::get();
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

    $data = [
        "id" => $ida,
        "nombre" => $nombreProveedor,
        "ciudad" => $ciudad,
        "correo" => $correo,
        "telefono" => $telefono,
        "estado" => $estado
    ];
    HttpClient::setUrl(URL.'/proveedores');
    HttpClient::setBody($data);
    $response = HttpClient::put();
    if($response['status']){
        echo '<script>
                alert("Actualizado con éxito!");
                window.location.href = "provedores.php";
              </script>';
        exit;
    } else {
        echo '<script>alert("Error en la actualización")</script>';
    }
    
}
?>
</body>
</html>
