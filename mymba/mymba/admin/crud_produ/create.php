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
<div class="contenedor" >
    <form action="create.php" method="post" enctype="multipart/form-data">
    <?php
require_once("../../database/conexion.php");
$conexion->set_charset("utf8");

?>
    <div class="title" ><h1>Agregar Producto</h1></div>
        <div class="con1">
        <div class="con1-1">
        <label for="" class="label">ID Producto</label>
        <input class="input is-primary" type="text"  name="id">
        </div>   
        <div class="con1-2">
        <label for="" class="label">Proveedor</label>
        <?php
         $sq = "SELECT*FROM proveedores";
         $resul = $conexion->query($sq);
         
        ?>
       <div class="select is-primary" id= "select" name="tipoid">
            <select name="proveedor" id="proveedor">
                <option value="0">Seleccione un proveedor</option>
                <?php
                while($row = $resul->fetch_assoc()){
                    $idpro = $row['idProveedor'];
                    $namepro = $row['nombreP'];
                    echo "<option value=\"$idpro\">$namepro</option>";
                }
                ?>
            </select>
        </div>
        </div>
    </div>


        <div class="con2">
            <div class="con2-1">
        <label for="" class="label">Nombre</label>
        <input class="input is-primary" type="text" name="nombre">
        </div>
        <div class="con2-2">
        <label for="" class="label">Descripcion</label>
        <textarea class="textarea is-primary" id="textarea" type="text" name="descripcion"></textarea>
        </div>
        </div>


        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Contenido</label>
        <input class="input is-primary" type="text" name="contenido">
        </div> 
        <div class="con3-2">
        <label for="" class="label">Precio</label>
        <input class="input is-primary" type="text" name="precio">
        </div> 
    </div>
    <div class="con4">
        <div class="con4-1">
            <label class="label" for="">Marca</label>

        <?php
         $sqe = "SELECT*FROM marcas";
         $resul = $conexion->query($sqe);
         
        ?>
       <div class="select is-primary" id= "select" name="marca">
            <select name="marca" id="marca">
                <option value="0">Seleccione una marca</option>
                <?php
                while($row = $resul->fetch_assoc()){
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
        <?php
         $sqe = "SELECT*FROM categorias";
         $resul = $conexion->query($sqe);
        ?>
         <div class="select is-primary" id= "select" name="categoria">
            <select name="categoria" id="categoria">
                <option value="0">Seleccione una categoria</option>
                <?php
                while($row = $resul->fetch_assoc()){
                    $idcat = $row['categoria'];
                    $namecat = $row['descripcion'];
                    echo "<option value=\"$idcat\">$namecat</option>";
                }
                ?>
            </select>
        </div>
    </div>
    </div>
    <div class="con5">
        <div class="con5-1">
            <label for="" class="label">Imagen del producto</label>
            <input type="file" class="file is-primary" name="imagen">
        </div>
    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Agregar</button>
    </div>
    

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_producto = $_POST['id'];
    $proveedor = $_POST['proveedor'];
    $nombreproducto = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contenido = $_POST['contenido'];
    $precio = $_POST['precio'];
    $marca = $_POST['marca'];
    $categoria = $_POST['categoria'];
    if ($_FILES['imagen']['error'] === 0) {
        $imagen = ($_FILES["imagen"]["tmp_name"]);
        $img = addslashes(file_get_contents($imagen));
    } else {
        echo "Error al subir la imagen.";
        exit();
    }


    $sqli = "INSERT INTO `productos` (`idProducto`, `proveedor`, `nombre`, `descripcionP`, `contenido`, `precio`,`marca`,`categoria`,`imagen`) VALUES ('$id_producto', '$proveedor', '$nombreproducto', '$descripcion', '$contenido', '$precio','$marca','$categoria', '$img')";
    $resultado = mysqli_query($conexion, $sqli);
if ($resultado == true) {
    echo '<div class="message is-primary" id="message">';
    echo '<p>Insercion de producto exitosa</p>';
    echo '<a href="productos.php" class="button is-primary">Volver</a>';
    echo '</div>';
} else {
    echo "Error al agregar el usuario: "          ;         
    echo '<div class="message is-danger" id="message">';
    echo '<p>Insercion de producto no realizada</p>';
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