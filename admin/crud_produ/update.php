<?php
session_start();
include '../../config.php';
include '../../models/Http.php';
if (isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
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
    <link rel="stylesheet" href="./estyles/norm.css">
    <title>Actualizar Producto</title>
</head>

<body>
    <div class="contenedor">
        <form action="update.php" method="post" enctype="multipart/form-data">
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $id = $_GET["id"];
                HttpClient::setUrl(URL.'/productos/read/'.$id);
                $roe = HttpClient::get();
            }
            ?>
            <div class="title">
                <h1>Actualizar Producto </h1>
            </div>
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
                            
                            echo "<option value=".$roe['proveedor']['idProveedor'].">".$roe['proveedor']['nombreP']."</option>";
                            

                            HttpClient::setUrl(URL.'/proveedores');
                            $proveedores = HttpClient::get();
                            $proveedores = $proveedores['proveedores'];

                            foreach($proveedores as $provedor){
                                $idProveedor = $row['idProveedor'];
                                $nombreProveedor = $row['nombreP'];
                                echo "<option value=\"$idProveedor\">$nombreProveedor</option>";
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
                            <option value="<?php echo isset($roe['marca']['idMarca']) ? $roe['marca']['idMarca'] : ''; ?>"><?php echo isset($roe['marca']['marca']) ? $roe['marca']['marca'] : ''; ?></option>
                            <?php
                            HttpClient::setUrl(URL.'/marcas');
                            $marcas = HttpClient::get();

                            foreach($marcas as $marca){
                                echo "<option value=".$marca['idMarca'].">".$marca['marca']."</option>";
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
                    
                             echo "<option value=".$roe['categoria']['categoria'].">".$roe['categoria']['descripcion']."</option>";
                                HttpClient::setUrl(URL.'/categorias');
                                $categorias = HttpClient::get();

                                foreach($categorias as $categoria){
                                    echo "<option value=".$categoria['categoria'].">".$categoria['descripcion']."</option>";
                                }
                               ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="con5">
                <label for="" class="label">Imagen</label>
                <input class="input is-primary" type="text" value="<?php echo isset($roe['imagen']) ? $roe['imagen'] : ''; ?>" name="direccion">

                <?php $imagenBLOB = isset($roe["imagen"]) ? $roe['imagen'] : '';
                echo '<img src="' . $imagenBLOB . '" alt="Imagen de Producto" width="200px">';
                ?>
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
                $imagen = $_POST['direccion'];

                $data = [
                    'id'=>$ida,
                    'proveedor' => $proveedor,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'contenido' => $contenido,
                    'precio' => $precio,
                    'marca' => $marca,
                    'categoria'=>$categoria,
                    'stock'=>$stock,
                    'imagen' => $imagen
                ];
            
                /*{
                    "id": "1",
                    "proveedor":101,
                    "nombre": "Purgante Canisan",
                    "descripcion": "Purgante para gato 100 EFECTIVOI",
                    "contenido": "2.5 ML",
                    "precio": "200000",
                    "marca": 1,
                    "categoria":6,
                    "stock": 58,
                    "imagen": "https://i.postimg.cc/tTP2SzDz/156397-800-auto.jpg"
                  }*/
                HttpClient::setUrl(URL.'/productos/update');
                HttpClient::setBody($data);
                $responseData = HttpClient::post();
                    if ($responseData['status']) {
                        echo '<div class="notification is-success">';
                        echo '<button class="delete"></button>';
                        echo '¡Producto actualizado correctamente';
                        echo '<br><a href="./productos.php">Volver</a>';
                        echo '</div>';
                    } else {
                        echo '<div class="notification is-danger">';
                        echo '<button class="delete"></button>';
                        echo '</div>';
                    }
                
            }
            ?>



    </div>
    </form>
</body>

</html>