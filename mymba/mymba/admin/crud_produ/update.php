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
    <form action="update.php" method="post" enctype="multipart/form-data">
    <?php
$conexion = new mysqli("localhost", "root", "", "mymba", 3306);
$conexion->set_charset("utf8");
if($_SERVER["REQUEST_METHOD"] === "GET"){
$id = $_GET["id"];
$sql = "SELECT*FROM productos WHERE idProducto = '$id' ";
$result = $conexion->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
}}
?>
    <div class="title" ><h1>Actualizar Producto </h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['idProducto']) ? $row['idProducto'] : ''; ?>" name="id" readonly>
        </div>
        <div class="con1-2">
        <label for="" class="label">Proveedor</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['proveedor']) ? $row['proveedor'] : ''; ?>" name="proveedor">
        </div>   
    </div>
        <div class="con2">
        <div class="con2-1">
        <label for="" class="label">Nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['nombre']) ? $row['nombre'] : ''; ?>" name="nombre">
        </div> 
            <div class="con2-2">
        <label for="" class="label">Descripcion</label>
        <textarea class="textarea is-primary" type="text" value="" name="descripcion"><?php echo isset($row['descripcionP']) ? $row['descripcionP'] : ''; ?></textarea>
        </div>
        
        </div>
        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Contenido</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['contenido']) ? $row['contenido'] : ''; ?>" name="contenido">
        </div>
            <div class="con3-2">
        <label for="" class="label">Precio</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['precio']) ? $row['precio'] : ''; ?>" name="precio">
        </div>  
    </div>
    <div class="con4">
        <div class="con4-1">
            <label for="" class="label">Marca</label>
            <input type="text" class="input is-primary" value="<?php echo isset($row['marca']) ? $row['marca'] : ''; ?>" name="marca">
        </div>
        <div class="con4-2">
            <label for="" class="label">Categoria</label>
            <input type="text" class="input is-primary" value="<?php echo isset($row['categoria']) ? $row['categoria'] : ''; ?>" name="categoria">
        </div>
    </div>
    <div class="con5">
        <label for="" class="label">Imagen</label>

        <?php $imagenBLOB = isset($row["imagen"]) ? $row['imagen']:'';
              $imagenBase64 = base64_encode($imagenBLOB);
              echo '<img src="data:' . $imagenBase64 . ';base64,' . base64_encode($imagenBLOB) . '" alt="Imagen de Producto" width="300px">'
                ?>
        <label for="" class="label">Nueva imagen</label>
        <input type="file" name="imagen">

    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Actualizar</button>
    </div>
    

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $ida = $_POST['id'];
    $proveedor = $_POST['proveedor'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contenido = $_POST['contenido'];
    $precio = $_POST['precio'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
  
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];
        $img = addslashes(file_get_contents($imagen['tmp_name']));
        $sqli = "UPDATE productos SET `idProducto` = '$ida', `proveedor` = '$proveedor', `nombre` = '$nombre', `descripcionP` = '$descripcion', `contenido` = '$contenido', `precio` = '$precio', `marca` = '$marca', `categoria` = '$categoria', `imagen`='$img' WHERE `productos`.`idProducto` = '$ida'";
    }else{
        $sqli = "UPDATE productos SET `idProducto` = '$ida', `proveedor` = '$proveedor', `nombre` = '$nombre', `descripcionP` = '$descripcion', `contenido` = '$contenido', `precio` = '$precio', `marca` = '$marca', `categoria` = '$categoria' WHERE `productos`.`idProducto` = '$ida'";
    }
    $resultado = mysqli_query($conexion, $sqli);
if ($resultado== true) {
    echo '<div class="message is-primary" id="message">';
    echo '<p>Actualización de producto exitosa</p>';
    echo '<a href="productos.php" class="button is-primary">Volver</a>';
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