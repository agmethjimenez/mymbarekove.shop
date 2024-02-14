<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();

if(isset($_GET['pedido']) && isset($_GET['producto'])){
    $idpedido = $_GET['pedido'];
    $idproducto = $_GET['producto'];

    $sql1 = "SELECT precio FROM productos WHERE idProducto = '$idproducto'";
    $resul = $conexion->query($sql1);
    $row = $resul->fetch_assoc();

    $precioproducto = $row['precio'];

    




    $sql = "UPDATE detallepedido SET cantidad = cantidad + 1, total = cantidad*? WHERE idPedido = ? AND idProducto = ?";
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
    header("location: verpedidos.php");
}
?>