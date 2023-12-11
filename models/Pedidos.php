<?php
//("../database/conexion.php");
//$database = new Database();
//$conexion = $database->connect();

class Pedido{
    public function Traerpedido($id_usuario,$id_pedido,$ciudad, $direccion, $producto, $cantidad, $total){
        global $conexion;
        $conexion->begin_transaction();
        try {
        $sql = "INSERT INTO pedidos VALUES (?,?,?,?,CURDATE(),3)";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("ssss",$id_pedido,$id_usuario,$ciudad, $direccion);
        $bin->execute();

        $sql2 = "INSERT INTO detallepedido VALUES(?,?,?,?)";
        $bin2 = $conexion->prepare($sql2);
        $bin2->bind_param("ssss",$id_pedido, $producto, $cantidad, $total);
        $bin2->execute();

        $conexion->commit();

        $respuesta = array('exito' => true, 'mensaje' => 'Pedido exitoso');
        return json_encode($respuesta);

    }catch (Exception $e) {
        $conexion->rollback();

        // Enviar una respuesta de error al cliente
        $respuesta = array('exito' => false, 'mensaje' => 'Error en la transacción: ' . $e->getMessage());
        return json_encode($respuesta);
        }


    }
}

?>