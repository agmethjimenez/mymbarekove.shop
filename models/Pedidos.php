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

                $sqlStock = "UPDATE productos SET cantidadDisponible = cantidadDisponible - ? WHERE idProducto = ? ";
                $stmtStock = $conexion->prepare($sqlStock);
                $stmtStock->bind_param("ss",$cantidad,$idProducto);
                $stmtStock->execute();

                $stmtDetalle->close();
            }
    
            $conexion->commit();
    
            return json_encode(['exito' => true, 'mensaje' => 'Pedido exitoso']);
        } catch (Exception $e) {
            $conexion->rollback();
            throw $e;
        }
    }

    public function getPedidos($conexion, $id) {
        if ($id === null) {
            $sql = "SELECT p.idPedido,u.identificacion, CONCAT(u.primerNombre, ' ', COALESCE(u.segundoNombre, ''), ' ', u.primerApellido, ' ', COALESCE(u.segundoApellido, '')) AS nombreCompleto, p.ciudad, p.direccion, p.fecha, p.total, p.detalles_pago 
                    FROM pedidos as p
                    LEFT JOIN usuarios as u ON p.usuario = u.id";
        } else {
            $sql = "SELECT p.idPedido,u.identificacion, CONCAT(u.primerNombre, ' ', COALESCE(u.segundoNombre, ''), ' ', u.primerApellido, ' ', COALESCE(u.segundoApellido, '')) AS nombreCompleto, p.ciudad, p.direccion, p.fecha, p.total, p.detalles_pago 
                    FROM pedidos as p 
                    LEFT JOIN usuarios as u ON p.usuario = u.id
                    WHERE p.idPedido = ?";
        }
    
        $resultados = array();
    
        if ($stmt = $conexion->prepare($sql)) {
            if ($id !== null) {
                $stmt->bind_param("s", $id);
            }
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($fila = $result->fetch_assoc()) {
                $fila['detalles_pago'] = json_decode($fila['detalles_pago']);
                $sql2 = "SELECT dp.idProducto, p.nombre, dp.cantidad, dp.total FROM detallepedido as dp
                    INNER JOIN productos as p ON p.idProducto = dp.idProducto
                    WHERE idPedido = ?";
                $bin = $conexion->prepare($sql2);
                $bin->bind_param("s", $fila['idPedido']);
                $bin->execute();
                $detalles = $bin->get_result()->fetch_all(MYSQLI_ASSOC);
    
                $fila['details'] = $detalles;
                $resultados[] = $fila;
            }
    
            $stmt->close();
        }
    
        // Verifica si no se encontraron resultados
        if (empty($resultados) && $id === null) {
            return [];
        }
    
        $jsonResult = $resultados;
    
        return $jsonResult;
    }
    
    
    
    


    public function getIdPago($conexion) {
        $idPago = null;
    
        $SQL = "SELECT detalles_pago FROM pedidos WHERE idPedido = ?";
        
        $stmt = $conexion->prepare($SQL);
        
        $stmt->bind_param("s", $this->idPedido);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            $detalles_pago_json = $row['detalles_pago'];
            
            $detalles_pago = json_decode($detalles_pago_json, true);
            
            if ($detalles_pago !== null && isset($detalles_pago['payment_id'])) {
                $idPago = $detalles_pago['payment_id'];
            }
        }
        
        $stmt->close();
        
        return $idPago;
    }
    
}

?>