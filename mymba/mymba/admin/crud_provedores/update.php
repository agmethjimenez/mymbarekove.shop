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
$conexion = new mysqli("localhost", "root", "", "mymba", 3306);
$conexion->set_charset("utf8");
if($_SERVER["REQUEST_METHOD"] === "GET"){
$id = $_GET["id"];
$sql = "SELECT*FROM proveedores WHERE estado = 'SI'";
$result = $conexion->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
}}
?>
    <div class="title" ><h1>Actualizar Datos</h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['idProveedor']) ? $row['idProveedor'] : ''; ?>" name="id" readonly>
        </div>
        <div class="con1-2">
        <label for="" class="label">Identificacion</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['nombre']) ? $row['nombre'] : ''; ?>" name="nombre">
        </div>   
    </div>
        <div class="con2">
        <div class="con2-1">
        <label for="" class="label">Identificacion</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['ciudad']) ? $row['ciudad'] : ''; ?>" name="ciudad">
        </div> 
            <div class="con2-2">
        <label for="" class="label">Tipo de ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['correo']) ? $row['correo'] : ''; ?>" name="correo">
        </div>
        
        </div>
        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Primer nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['telefono']) ? $row['telefono'] : ''; ?>" name="telefono">
        </div>
            <div class="con3-2">
        <label for="" class="label">Segundo nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['estado']) ? $row['estado'] : ''; ?>" name="estado" readonly>
        </div>  
    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Actualizar</button>
    </div>
    

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $ida = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    $sqli = "UPDATE `proveedores` SET `nombre` = '$nombre', `ciudad` = '$ciudad', `correo` = '$correo', `telefono` = '$telefono' WHERE `proveedores`.`idProveedor` = '$ida'";

if ($conexion->query($sqli) === true) {
    echo '<div class="message is-primary" id="message">';
    echo '<p>Actualización exitosa</p>';
    echo '<a href="provedores.php" class="button is-primary">Volver</a>';
    echo '</div>';

    $sql = "SELECT * FROM usuarios WHERE id='$ida'";
    $result = $conexion->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
    } else {
        echo "Error al cargar los datos actualizados";
        
    }
} else {
    echo "Error al actualizar el usuario: " . $conexion->error;
}
}

    ?>
    </div>
    </form>
    </body>
</html>