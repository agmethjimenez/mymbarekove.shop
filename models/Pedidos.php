<?php
//("../database/conexion.php");
//$database = new Database();
//$conexion = $database->connect();

class Pedido {
    /*public function Traerpedido($id_usuario,$id_pedido,$ciudad, $direccion, $producto, $cantidad, $total){
        global $conexion;
        $conexion->begin_transaction();
        try {
        $sql = "INSERT INTO pedidos VALUES (?,?,?,?,CURDATE(),4)";
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


    }*/
    public function Traerpedido($id_usuario, $id_pedido, $ciudad, $direccion, $detalles, $totalP, $detalles_pago)
{
    global $conexion;
    $conexion->begin_transaction();
    $detalles_pagoJSON = json_encode($detalles_pago);
    try {
        $sql = "INSERT INTO pedidos VALUES (?,?,?,?,NOW(),?,?,4)";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("ssssds", $id_pedido, $id_usuario, $ciudad, $direccion, $totalP, $detalles_pagoJSON);
        $bin->execute();

        foreach ($detalles as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $total = $producto['total'];

            $sql2 = "INSERT INTO detallepedido VALUES(?,?,?,?)";
            $bin2 = $conexion->prepare($sql2);
            $bin2->bind_param("ssdd", $id_pedido, $id_producto, $cantidad, $total);

            if (!$bin2->execute()) {
                $conexion->rollback();
                return json_encode(array('exito' => false, 'mensaje' => 'Error al insertar detalle de pedido.'));
            }

            $bin2->close();
        }

        $conexion->commit();

        $respuesta = array('exito' => true, 'mensaje' => 'Pedido exitoso');
        return json_encode($respuesta);

    } catch (Exception $e) {
        $conexion->rollback();
        $respuesta = array('exito' => false, 'mensaje' => 'Error en la transacción: ' . $e->getMessage());
        return json_encode($respuesta);
    }
    public function actualizarTotal($idpedido){
        global $conexion;
        $tottQuery = "SELECT SUM(dp.total) AS total_pedido FROM detallepedido as dp WHERE dp.idPedido = '$idpedido'";
        $resultTott = $conexion->query($tottQuery);
        // Verificar si la consulta fue exitosa
        if ($resultTott) {
            // Obtener el resultado como un array asociativo
            $totalRow = $resultTott->fetch_assoc();
            // Obtener el total
            $total_pedido = $totalRow['total_pedido'];
            $actualizartotal = "UPDATE pedidos SET total = ? WHERE idPedido = ?";
            $binactualizartotal = $conexion->prepare($actualizartotal);
            $binactualizartotal->bind_param("ss", $total_pedido, $idpedido);
            $binactualizartotal->execute();
        }
    }

    public function GetPedidos(){
        global $conexion;
        $sql = "SELECT p.idPedido, p.usuario, p.ciudad, p.direccion, p.fecha, p.total, e.estado FROM pedidos as p 
        INNER JOIN estados as e ON p.estado = e.codEst;";

    $resultados = array();

        if ($resultado = $conexion->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $resultados[] = $fila;
            }
            $resultado->free();
        }
        return $resultados;
}
}
    public function actualizarTotal($idpedido){
        global $conexion;
        $tottQuery = "SELECT SUM(dp.total) AS total_pedido FROM detallepedido as dp WHERE dp.idPedido = '$idpedido'";
        $resultTott = $conexion->query($tottQuery);
        // Verificar si la consulta fue exitosa
        if ($resultTott) {
            // Obtener el resultado como un array asociativo
            $totalRow = $resultTott->fetch_assoc();
            // Obtener el total
            $total_pedido = $totalRow['total_pedido'];
            $actualizartotal = "UPDATE pedidos SET total = ? WHERE idPedido = ?";
            $binactualizartotal = $conexion->prepare($actualizartotal);
            $binactualizartotal->bind_param("ss", $total_pedido, $idpedido);
            $binactualizartotal->execute();
        }
    }

    public function GetPedidos(){
        global $conexion;
        $sql = "SELECT p.idPedido, p.usuario, p.ciudad, p.direccion, p.fecha, p.total, e.estado FROM pedidos as p 
        INNER JOIN estados as e ON p.estado = e.codEst;";

    $resultados = array();

        if ($resultado = $conexion->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $resultados[] = $fila;
            }
            $resultado->free();
        }
        return $resultados;
}
}

?>