<?php
class Pedido extends Database {
    public function GETpedidos(){
        $conexion = parent::connect();
        $sql = "SELECT * FROM pedidos";
        $resultados = array();

        if ($resultado = $conexion->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $resultados[] = $fila;
            }
            $resultado->free();
        }
        return $resultados;
    }

    public function POSTusuario($id,$tipoid,$name1,$name2,$name3, $name4, $phone,$email, $password){
        $conexion = parent::connect();
        $hashedpass = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, clave) VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssssss", $id, $tipoid, $name1, $name2, $name3, $name4, $phone, $email, $hashedpass);

        $stmt->execute();

    }

    public function PUTpedidos($id,$estado){
        $conexion = parent::connect();
        $sql = "UPDATE pedidos SET estado = ? WHERE idPedido = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss",$estado,$id);

        $stmt->execute();
    }

    public function DELETEpedidos($id){
        $conexion = parent::connect();
        $sql = "START TRANSACTION;
        DELETE FROM detallepedido WHERE idPedido = 31;
        DELETE FROM pedidos WHERE idPedido = 31; 
        COMMIT;
        ROLLBACK;
        ";
        $as = $conexion->prepare($sql);
        $as->bind_param("s",$id);
        $as->execute();
    }

    public function POSTdostablas($idC,$tipoid,$name1,$name2,$name3, $name4, $phone,$email, $password,$IDP,$fecha, $estado){
        $conexion=parent::connect();
        $conexion->begin_transaction();

        $hashedpass = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (id, identificacion, tipoId, primerNombre, segundoNombre, primerApellido, segundoApellido, telefono, email, clave) VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssssss", $idC, $tipoid, $name1, $name2, $name3, $name4, $phone, $email, $hashedpass);
        $stmt->execute();

        $user = $stmt->insert_id;

        $sql="INSERT INTO pedidos (idPedido, usuario, fecha, estado) VALUES(?,?,?,?)";
        $stmt2 = $conexion->prepare($sql);
        $stmt2->bind_param("ssss", $IDP,$user,$fecha,$estado);
        $stmt2->execute();

        $conexion->commit();
    }
}

?>
