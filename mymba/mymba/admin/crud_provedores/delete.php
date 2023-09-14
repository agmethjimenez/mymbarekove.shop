<?php
$conexion = new mysqli("localhost", "root", "", "mymba", 3306);
$conexion->set_charset("utf8");

if($_SERVER["REQUEST_METHOD"] === "GET"){
$id = $_GET['id'];
$sql = "UPDATE `proveedores` SET `estado` = 'NO' WHERE `proveedores`.`idProveedor` = '$id'";

if ($conexion->query($sql)) {
    echo "Desactivacion exitosa";
    echo '<a href="provedores.php">Volver</a>';
} else {
    echo "Error al eliminar el usuario";
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
    <title>DELETE</title>
</head>
<body>
    
</body>
</html>