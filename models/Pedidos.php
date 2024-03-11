<?php
class Pedido {
    private $idPedido;
    private $idUsuario;
    private $ciudad;
    private $direccion;
    private $detalles;
    private $totalP;
    private $detallesPago;

    
    public function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setDetalles($detalles) {
        $this->detalles = $detalles;
    }

    public function setTotalP($totalP) {
        $this->totalP = $totalP;
    }

    public function setDetallesPago($detallesPago) {
        $this->detallesPago = $detallesPago;
    }

    public function actualizarTotal($conexion,$idPedido) {
        $tottQuery = "SELECT SUM(dp.total) AS total_pedido FROM detallepedido as dp WHERE dp.idPedido = ?";
        $stmt = $conexion->prepare($tottQuery);
        $stmt->bind_param("s", $idPedido);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $totalRow = $result->fetch_assoc();
            $total_pedido = $totalRow['total_pedido'];

            $actualizarTotal = "UPDATE pedidos SET total = ? WHERE idPedido = ?";
            $stmtActualizarTotal = $conexion->prepare($actualizarTotal);
            $stmtActualizarTotal->bind_param("ss", $total_pedido, $idPedido);
            $stmtActualizarTotal->execute();
        }
    }

    public function traerPedido($conexion) {    
        try {
            $sql = "INSERT INTO pedidos VALUES (?, ?, ?, ?, NOW(), ?, ?, 4)";
            $stmt = $conexion->prepare($sql);
            $detallesPagoJSON = json_encode($this->detallesPago);
            $detallesPagoJSON = substr($detallesPagoJSON, 0, 255); 
            $stmt->bind_param("ssssds", $this->idPedido, $this->idUsuario, $this->ciudad, $this->direccion, $this->totalP, $detallesPagoJSON);
            $stmt->execute();
    
            foreach ($this->detalles as $producto) {
                $idProducto = $producto['id'];
                $cantidad = $producto['cantidad'];
                $total = $producto['total'];
    
                $sqlDetalle = "INSERT INTO detallepedido VALUES (?, ?, ?, ?)";
                $stmtDetalle = $conexion->prepare($sqlDetalle);
    
                $stmtDetalle->bind_param("ssdd", $this->idPedido, $idProducto, $cantidad, $total);
    
                if (!$stmtDetalle->execute()) {
                    throw new Exception("Error al insertar detalle de pedido: " . $stmtDetalle->error);
                }
    
                $stmtDetalle->close();
            }
    
            $conexion->commit();
    
            return json_encode(['exito' => true, 'mensaje' => 'Pedido exitoso']);
        } catch (Exception $e) {
            $conexion->rollback();
            throw $e;
        }
    }

    public function getPedidos($conexion) {
        $sql = "SELECT p.idPedido, p.usuario, p.ciudad, p.direccion, p.fecha, p.total, e.estado FROM pedidos as p 
            INNER JOIN estados as e ON p.estado = e.codEst;";
        $resultados = array();

        if ($result = $conexion->query($sql)) {
            while ($fila = $result->fetch_assoc()) {
                $resultados[] = $fila;
            }
            $result->free();
        }
        return $resultados;
    }
}

?>