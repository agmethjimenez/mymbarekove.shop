<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();

if(isset($_GET['pedido']) && isset($_GET['producto'])){
    $idpedido = $_GET['pedido'];
    $idproducto = $_GET['producto'];

    $verificar = "SELECT cantidad FROM detallepedido WHERE idPedido = ? AND idProducto = ?";
    $binverificar = $conexion->prepare($verificar);
    $binverificar->bind_param("ss",$idpedido,$idproducto);
    $binverificar->execute();
    $verificador = $binverificar->get_result();

    if($verificador->num_rows > 0){
        $row = $verificador->fetch_assoc();
        $cantidadestablecida = $row['cantidad'];

        if($cantidadestablecida > 1){
            $sql1 = "SELECT precio FROM productos WHERE idProducto = '$idproducto'";
    $resul = $conexion->query($sql1);
    $row2 = $resul->fetch_assoc();
    $precioproducto = $row2['precio'];

            $sql = "UPDATE detallepedido SET cantidad = cantidad- 1, total = cantidad*? WHERE idPedido = ? AND idProducto = ?";
    $bin = $conexion->prepare($sql);
    $bin->bind_param("sss",$precioproducto,$idpedido,$idproducto);

    if($bin->execute()){
        echo'<script>alert("Restado exitosamente del pedido")</script>';
        header('Location: detallepedido.php?id='. $idpedido .'');
        /*echo '<div class="message is-primary" id="message">';
        echo '<p>Producto borrado exitosamente</p>';
        echo '<a class="button is-primary" href="login.php">Inicia Sesion</a>';
        echo '</div>';*/
    }else{
        echo '<div class="message is-primary" id="message">';
        echo '<p>No restado</p>';
        echo '<a class="button is-primary" href="login.php">Inicia Sesion</a>';
        echo '</div>';
    }
        }else{
            $sqlEliminar = "DELETE FROM detallepedido WHERE idPedido = ? AND idProducto = ?";
            $stmtEliminar = $conexion->prepare($sqlEliminar);
            $stmtEliminar->bind_param("ss", $idpedido, $idproducto);

            if($stmtEliminar->execute()){
                echo'<script>alert("Producto eliminado del pedido")</script>';
                header('Location: detallepedido.php?id='. $idpedido .'');
            } else {
                echo '<div class="message is-primary" id="message">';
                echo '<p>No se pudo eliminar el producto del pedido</p>';
                echo '<a class="button is-primary" href="login.php">Inicia Sesion</a>';
                echo '</div>';
            }
        }
    }else{
        echo '<div class="message is-primary" id="message">';
        echo '<p>No se encontró el producto en el pedido</p>';
        echo '<a class="button is-primary" href="login.php">Inicia Sesion</a>';
        echo '</div>';
    }

    

}else{
    header("location: verpedidos.php");
}
?>