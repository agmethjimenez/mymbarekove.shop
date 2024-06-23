<?php
class Proveedor
{
    private $idProveedor;
    private $nombre;
    private $ciudad;
    private $correo;
    private $telefono;

    public function setIdProveedor($idProveedor)
    {
        $this->idProveedor = $idProveedor;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function GETproveedores($conexion, $id = null, $name = null)
{
    $sql = "SELECT * FROM proveedores WHERE estado = true";
    
    if ($id !== null) {
        $sql .= " AND idProveedor = :id";
    }
    if ($name !== null) {
        $sql .= " AND nombreP LIKE :name";
    }

    $stmt = $conexion->prepare($sql);

    if ($id !== null) {
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    }
    if ($name !== null) {
        $name = "%$name%";
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    }
    if ($stmt->execute()) {
        $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return ["acceso" => false, "mensaje" => "Error al obtener proveedores: " . $stmt->errorInfo()[2]];
    }

    return $proveedores;
}



public function POSTproveedores($conexion)
{
    $idproveedor = rand(1000, 9999);

    $sql = "INSERT INTO proveedores(idProveedor, nombreP, ciudad, correo, telefono) VALUES (:idProveedor, :nombre, :ciudad, :correo, :telefono)";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":idProveedor", $this->idProveedor);
    $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
    $stmt->bindParam(":ciudad", $this->ciudad, PDO::PARAM_STR);
    $stmt->bindParam(":correo", $this->correo, PDO::PARAM_STR);
    $stmt->bindParam(":telefono", $this->telefono, PDO::PARAM_STR);

    if ($stmt->execute()) {
        return ["status" => true, "mensaje" => "Insertado correctamente"];
    } else {
        return ["status" => false, "mensaje" => "Error al insertar proveedor: " . $stmt->errorInfo()[2]];
    }
}


public function PUTprovedores($conexion)
{
    $sql = "UPDATE proveedores SET nombreP = :nombre, ciudad = :ciudad, correo = :correo, telefono = :telefono WHERE idProveedor = :idProveedor AND estado = true";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
    $stmt->bindParam(":ciudad", $this->ciudad, PDO::PARAM_STR);
    $stmt->bindParam(":correo", $this->correo, PDO::PARAM_STR);
    $stmt->bindParam(":telefono", $this->telefono, PDO::PARAM_STR);
    $stmt->bindParam(":idProveedor", $this->idProveedor);

    if ($stmt->execute()) {
        return ["status" => true, "mensaje" => "Actualizado correctamente"];
    } else {
        return ["status" => false, "mensaje" => "Error al actualizar proveedor: " . $stmt->errorInfo()[2]];
    }
}

}