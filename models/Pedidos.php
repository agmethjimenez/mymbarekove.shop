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
            $detallesPagoJSON = json_encode($this->detallesPago);
            $detallesPagoJSON = substr($detallesPagoJSON, 0, 255); 
    
            $conexion->beginTransaction();
    
            $sqlPedido = "INSERT INTO pedidos (idPedido, usuario, ciudad, direccion, fecha, total, detalles_pago, estado) 
                          VALUES (:idPedido, :idUsuario, :ciudad, :direccion, NOW(), :total, :detalles_pago, 1)";
            $stmtPedido = $conexion->prepare($sqlPedido);
    
            $stmtPedido->bindParam(":idPedido", $this->idPedido);
            $stmtPedido->bindParam(":idUsuario", $this->idUsuario);
            $stmtPedido->bindParam(":ciudad", $this->ciudad);
            $stmtPedido->bindParam(":direccion", $this->direccion);
            $stmtPedido->bindParam(":total", $this->totalP);
            $stmtPedido->bindParam(":detalles_pago", $detallesPagoJSON);
    
            $stmtPedido->execute();
    
            foreach ($this->detalles as $producto) {
                $idProducto = $producto['id'];
                $cantidad = $producto['cantidad'];
                $total = $producto['total'];
    
                $sqlDetalle = "INSERT INTO detallepedido (idPedido, idProducto, cantidad, total) 
                               VALUES (:idPedido, :idProducto, :cantidad, :total)";
                $stmtDetalle = $conexion->prepare($sqlDetalle);
    
                $stmtDetalle->bindParam(":idPedido", $this->idPedido);
                $stmtDetalle->bindParam(":idProducto", $idProducto);
                $stmtDetalle->bindParam(":cantidad", $cantidad);
                $stmtDetalle->bindParam(":total", $total);
    
                if (!$stmtDetalle->execute()) {
                    throw new Exception("Error al insertar detalle de pedido: " . $stmtDetalle->errorInfo()[2]);
                }
    
                $sqlStock = "UPDATE productos SET cantidadDisponible = cantidadDisponible - :cantidad WHERE idProducto = :idProducto";
                $stmtStock = $conexion->prepare($sqlStock);
                $stmtStock->bindParam(":cantidad", $cantidad);
                $stmtStock->bindParam(":idProducto", $idProducto);
                $stmtStock->execute();
    
                $stmtDetalle->closeCursor(); 
            }
    
            $conexion->commit();
    
            return json_encode(['exito' => true, 'mensaje' => 'Pedido exitoso']);
        } catch (PDOException $e) {
            $conexion->rollBack();
            throw $e;
        }
    }

    public function getPedidos($conexion, $id) {
        if ($id === null) {
            $sql = "SELECT p.idPedido, u.identificacion, CONCAT(u.primerNombre, ' ', COALESCE(u.segundoNombre, ''), ' ', u.primerApellido, ' ', COALESCE(u.segundoApellido, '')) AS nombreCompleto, p.ciudad, p.direccion, p.fecha, p.total, p.detalles_pago, e.estado 
                    FROM pedidos as p
                    LEFT JOIN usuarios as u ON p.usuario = u.id
                    LEFT JOIN estados as e ON e.codEst = p.estado";
        } else {
            $sql = "SELECT p.idPedido, u.identificacion, CONCAT(u.primerNombre, ' ', COALESCE(u.segundoNombre, ''), ' ', u.primerApellido, ' ', COALESCE(u.segundoApellido, '')) AS nombreCompleto, p.ciudad, p.direccion, p.fecha, p.total, p.detalles_pago, e.estado 
                    FROM pedidos as p 
                    LEFT JOIN usuarios as u ON p.usuario = u.id
                    LEFT JOIN estados as e ON e.codEst = p.estado
                    WHERE p.idPedido = :idPedido";
        }
    
        $resultados = array();
    
        try {
            $stmt = $conexion->prepare($sql);
    
            if ($id !== null) {
                $stmt->bindParam(":idPedido", $id);
            }
    
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($result as $fila) {
                $fila['detalles_pago'] = json_decode($fila['detalles_pago']);
                
                $sql2 = "SELECT dp.idProducto, p.nombre, dp.cantidad, dp.total 
                         FROM detallepedido as dp
                         INNER JOIN productos as p ON p.idProducto = dp.idProducto
                         WHERE dp.idPedido = :idPedido";
    
                $stmt2 = $conexion->prepare($sql2);
                $stmt2->bindParam(":idPedido", $fila['idPedido']);
                $stmt2->execute();
                $detalles = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
                $fila['details'] = $detalles;
                $resultados[] = $fila;
            }
    
            return $resultados;
        } catch (PDOException $e) {
            echo "Error al obtener pedidos: " . $e->getMessage();
            return []; 
        }
    }
    
    
    
    
    


    public function getIdPago($conexion) {
        $idPago = null;
    
        $sql = "SELECT detalles_pago FROM pedidos WHERE idPedido = :idPedido";
        
        $stmt = $conexion->prepare($sql);
        
        $stmt->bindParam(":idPedido", $this->idPedido);
        
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result !== false) {
            $detalles_pago_json = $result['detalles_pago'];
            
            $detalles_pago = json_decode($detalles_pago_json, true);
            
            if ($detalles_pago !== null && isset($detalles_pago['payment_id'])) {
                $idPago = $detalles_pago['payment_id'];
            }
        }
        
        $stmt->closeCursor();
        
        return $idPago;
    }
    
    
}

?>