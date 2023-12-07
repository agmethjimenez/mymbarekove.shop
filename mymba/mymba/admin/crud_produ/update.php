<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./estyles/norm.css">
    <title>Document</title>
</head>
<body>
<div class="contenedor">
    <form action="update.php" method="post" enctype="multipart/form-data">
    <?php
require_once("../../database/conexion.php");
if($_SERVER["REQUEST_METHOD"] === "GET"){
$id = $_GET["id"];
$sql = "SELECT*FROM productos WHERE idProducto = '$id' ";
$result = $conexion->query($sql);

if ($result) {
    $roe = $result->fetch_assoc();
}}
?>
    <div class="title" ><h1>Actualizar Producto </h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['idProducto']) ? $roe['idProducto'] : ''; ?>" name="id" readonly>
        </div>
        <div class="con1-2">
        <label for="" class="label">Proveedor</label>
        <div class="select is-primary">
            <select name="proveedor" id="proveedor">
            <?php 
                $marcquey = "SELECT p.idProducto,pr.idProveedor as idprovedor, pr.nombreP FROM productos AS p INNER JOIN proveedores as pr ON p.proveedor = pr.idProveedor WHERE p.idProducto = '$id'";
                $resulmarca = $conexion->query($marcquey);
                            while ($row = $resulmarca->fetch_assoc()) {
                                $idmarca = $row['idprovedor'];
                                $namemarca = $row['nombreP'];
                                echo "<option value=\"$idmarca\">$namemarca</option>";
                            }
                            $sqe = "SELECT*FROM proveedores";
                            $resul = $conexion->query($sqe);
                            while ($row = $resul->fetch_assoc()) {
                                $idmar = $row['idProveedor'];
                                $namemar = $row['nombreP'];
                                echo "<option value=\"$idmar\">$namemar</option>";
                            }               
            ?>
            </select>
        
        </div>
        </div>   
    </div>
        <div class="con2">
        <div class="con2-1">
        <label for="" class="label">Nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['nombre']) ? $roe['nombre'] : ''; ?>" name="nombre">
        <label for="" class="label">Stock</label>
        <input type="number" class="input is-primary" value="<?php echo isset($roe['cantidadDisponible']) ? $roe['cantidadDisponible'] : ''; ?>" name="stock">
        </div> 
            <div class="con2-2">
        <label for="" class="label">Descripcion</label>
        <textarea class="textarea is-primary" type="text" id="descripcion" value="" name="descripcion"><?php echo isset($roe['descripcionP']) ? $roe['descripcionP'] : ''; ?></textarea>
        </div>
        
        </div>
        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Contenido</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['contenido']) ? $roe['contenido'] : ''; ?>" name="contenido">
        </div>
            <div class="con3-2">
        <label for="" class="label">Precio</label>
        <input class="input is-primary" type="text" value="<?php echo isset($roe['precio']) ? $roe['precio'] : ''; ?>" name="precio">
        </div>  
    </div>
    <div class="con4">
        <div class="con4-1">      
            <label for="" class="label">Marca</label>
            <div class="select is-primary">
                <select name="marca" id="marca">
                <?php 
                $marcquey = "SELECT p.idProducto,m.idMarca, m.marca FROM productos AS p INNER JOIN marcas as m ON p.marca = m.idMarca WHERE p.idProducto = '$id'";
                $resulmarca = $conexion->query($marcquey);
                            while ($row = $resulmarca->fetch_assoc()) {
                                $idmarca = $row['idMarca'];
                                $namemarca = $row['marca'];
                                echo "<option value=\"$idmarca\">$namemarca</option>";
                            }
                            $sqe = "SELECT*FROM marcas";
                            $resul = $conexion->query($sqe);
                            while ($row = $resul->fetch_assoc()) {
                                $idmar = $row['idMarca'];
                                $namemar = $row['marca'];
                                echo "<option value=\"$idmar\">$namemar</option>";
                            }
        
                            
            ?>
                </select>

            </div>
        </div>
        <div class="con4-2">
            <label for="" class="label">Categoria</label>
            <div class="select is-primary">
                <select name="categoria" id="categoria">
                <?php 
                $marcquey = "SELECT p.idProducto,c.categoria as idcategoria, c.descripcion as categoria FROM productos AS p INNER JOIN categorias as c ON p.categoria = c.categoria WHERE p.idProducto = '$id'";
                $resulmarca = $conexion->query($marcquey);
                            while ($row = $resulmarca->fetch_assoc()) {
                                $idmarca = $row['idcategoria'];
                                $namemarca = $row['categoria'];
                                echo "<option value=\"$idmarca\">$namemarca</option>";
                            }
                            $sqe = "SELECT*FROM categorias";
                            $resul = $conexion->query($sqe);
                            while ($row = $resul->fetch_assoc()) {
                                $idmar = $row['categoria'];
                                $namemar = $row['descripcion'];
                                echo "<option value=\"$idmar\">$namemar</option>";
                            }
        
                            
            ?>
                </select>
            </div>
        </div>
    </div>
    <div class="con5">
        <label for="" class="label">Imagen</label>

        <?php $imagenBLOB = isset($roe["imagen"]) ? $roe['imagen']:'';
        echo '<img src="../../catalogo/imgs/productos/' .$imagenBLOB. '" alt="Imagen de Producto" width="200px">';
                ?>
        <label for="" class="label">Nueva imagen</label>
        <input type="file" name="imagen">

    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Actualizar</button>
    </div>
    

    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ida = $_POST['id'];
    $proveedor = $_POST['proveedor'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contenido = $_POST['contenido'];
    $precio = $_POST['precio'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];
        $img = $imagen["name"];  // Corregido el nombre de la variable
        $ruta_destino = "../../catalogo/imgs/productos/" . $img;  // Corregido el nombre de la variable
        move_uploaded_file($imagen["tmp_name"], $ruta_destino);

        $sqli = "UPDATE productos SET `idProducto` = '$ida', `proveedor` = '$proveedor', `nombre` = '$nombre', `descripcionP` = '$descripcion', `contenido` = '$contenido', `precio` = '$precio', `marca` = '$marca', `categoria` = '$categoria', `cantidadDisponible`= '$stock', `imagen`='$img' WHERE `productos`.`idProducto` = '$ida'";
    } else {
        $sqli = "UPDATE productos SET `idProducto` = '$ida', `proveedor` = '$proveedor', `nombre` = '$nombre', `descripcionP` = '$descripcion', `contenido` = '$contenido', `precio` = '$precio', `marca` = '$marca', `categoria` = '$categoria', `cantidadDisponible`= '$stock' WHERE `productos`.`idProducto` = '$ida'";
    }
    $resultado = mysqli_query($conexion, $sqli);
    
    if ($resultado == true) {
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