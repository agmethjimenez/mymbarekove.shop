<?php
require_once("../database/conexion.php");
class Producto
{
    public function GetProductos(){
        global $conexion;
        $sql = "SELECT p.idProducto, pr.nombreP as proveedor,p.nombre,p.precio, ca.descripcion as categoria, p.imagen from productos as p 
        INNER JOIN proveedores as pr ON p.proveedor = pr.idProveedor 
        INNER JOIN categorias as ca ON p.categoria = ca.categoria WHERE p.activo = 1";

    $resultados = array();

        if ($resultado = $conexion->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $resultados[] = $fila;
            }
            $resultado->free();
        }
        return $resultados;
}
    
    function verProducto()
    {
        global $conexion;
        $sqlq = "SELECT*FROM productos WHERE activo = 1";
        $result = $conexion->query($sqlq);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagenBLOB = $row["imagen"];
                echo '<div class="producto">';
                echo '<img src="'. $imagenBLOB .'" alt="">';
                echo '<div class="informacion">';
                echo "<p>" . $row['nombre'] . "</p>";
                echo "<p>⭐️⭐️⭐️⭐️⭐️</p>";
                echo "<p class='precio'>$" . $row['precio'] . "</p>";
                echo '<button class="comprar" onclick="agregarAlCarrito(\'' . $row['nombre'] . '\',' . $row['precio'] . ',\'' . $row['idProducto'] . '\',1,\'' . $imagenBLOB . '\')">Comprar</button>';
                echo '<button class="detalles" id="detalles"><a href="../catalogo/paginaproducto.php?id=' . $row['idProducto'] . '" class="dety">Detalles</a></button>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
    function detallesProducto($id)
    {
        global $conexion;
        $sql = "SELECT p.idProducto, pr.nombreP, p.nombre, p.descripcionP, p.contenido, p.precio, m.marca, c.descripcion,p.cantidadDisponible, p.imagen FROM productos as p 
        INNER JOIN proveedores as pr ON p.proveedor = pr.idProveedor
        INNER JOIN marcas as m ON p.marca = m.idMarca
        INNER JOIN categorias as c ON p.categoria = c.categoria
        WHERE p.idProducto = '$id'";
        $result = $conexion->query($sql);
        $row = $result->fetch_assoc();
        if($result->num_rows > 0){
            $imagenBLOB = $row['imagen'];
            echo '<div class="imagenpro">';
            echo '<img src="./imgs/productos/'. $imagenBLOB .'" alt="">';
            echo '</div>';
            echo '<div class="detalles">';
            echo '<div class="nombre"><h4>'. $row['nombre'] .'</h4></div>';
            echo '<div class="categoria"><p>Categoria:'. $row['descripcion'] .' </p></div>';
            echo '<div class="precio"><p>Precio: $'. $row['precio'] .'</p></div>';
            echo '<div class="descripcion"><p>Descripcion:<br> '. $row['descripcionP'] .'</p></div>';
            echo '<div class="contenido"><p>Contenido: '. $row['contenido'] .'</p></div>';
            echo '<div class="marca"><p>Marca: '. $row['marca'] .'</p></div>';   
            echo '<div class="disponibles"><p>Disponible: '. $row['cantidadDisponible'] .'</p></div>';
            echo '<button class="comprar" onclick="agregarAlCarrito(\'' . $row['nombre'] . '\',' . $row['precio'] . ',\'' . $row['idProducto'] . '\',1,\'' . $imagenBLOB . '\')">Comprar</button>';
            echo '</div>';           
        }

    }
}

    

?>
