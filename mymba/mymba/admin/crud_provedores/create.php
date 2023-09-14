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
    <?php
$conexion = new mysqli("localhost", "root", "", "mymba", 3306);
$conexion->set_charset("utf8");

?>
    <div class="title" ><h1>Agregar Proveedor</h1></div>
        <div class="con1">
        <div class="con1-1">
        <label for="" class="label">ID Proveedor</label>
        <input class="input is-primary" type="text"  name="id">
        </div>   
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
    

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_provedor = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $sqli = "INSERT INTO `proveedores` (`idProveedor`, `nombre`, `ciudad`, `correo`, `telefono`, `estado`) VALUES ('$id_provedor', '$nombre', '$ciudad', '$correo', '$telefono', 'SI');";

if ($conexion->query($sqli) === true) {
    echo '<div class="message is-primary" id="message">';
    echo '<p>Insercion de proveedor Exitosa</p>';
    echo '<a href="provedores.php" class="button is-primary">Volver</a>';
    echo '</div>';
} else {
    echo "Error al agregar el usuario: "          ;         
    echo '<div class="message is-danger" id="message">';
    echo '<p>Insercion de usuario no exitosa</p>';
    echo $conexion->error;
    echo '<a href="provedores.php" class="button is-primary">Volver</a>';
    echo '</div>';
}
}

    ?>
    </div>
    </form>
    </body>
</html>