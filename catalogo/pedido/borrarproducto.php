<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();

if(isset($_GET['pedido']) && isset($_GET['producto'])){
    $idpedido = $_GET['pedido'];
    $idproducto = $_GET['producto'];


    $sql = "DELETE FROM detallepedido WHERE idPedido = ? AND idProducto = ?";
    $bin = $conexion->prepare($sql);
    $bin->bind_param("ss",$idpedido,$idproducto);

    if($bin->execute()){
        echo'<script>alert("Borrado exitosamente del pedido")</script>';
        header('Location: detallepedido.php?id='. $idpedido .'');
        /*echo '<div class="message is-primary" id="message">';
        echo '<p>Producto borrado exitosamente</p>';
        echo '<a class="button is-primary" href="login.php">Inicia Sesion</a>';
        echo '</div>';*/
    }else{
        echo '<div class="message is-primary" id="message">';
        echo '<p>No borrado</p>';
        echo '<a class="button is-primary" href="login.php">Inicia Sesion</a>';
        echo '</div>';
    }

}else{
    header("location: verpedidos.php");
}
?>