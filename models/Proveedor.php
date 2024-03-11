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

    public function GETproveedores($conexion, $id)
    {
        if ($id === null) {
            $sql = "SELECT * FROM proveedores WHERE estado = 'SI'";
        } else {
            $sql = "SELECT * FROM proveedores WHERE estado = 'SI' AND idProveedor = $id";
        }
        $proveedores = array();
        $resultado = $conexion->query($sql);

        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $proveedores[] = $fila;
            }
            $resultado->free();
        }
        return $proveedores;
    }

    public function POSTproveedores($conexion)
    {
        $idproveedor = rand(1000, 9999);

        $sql = "INSERT INTO proveedores(idProveedor, nombreP, ciudad, correo, telefono) VALUES (?, ?, ?, ?, ?)";

        $bin = $conexion->prepare($sql);
        $bin->bind_param("sssss", $this->idProveedor, $this->nombre, $this->ciudad, $this->correo, $this->telefono);

        if ($bin->execute()) {
            return ["acceso" => true, "mensaje" => "Insertado correctamente"];
        } else {
            return ["acceso" => false, "mensaje" => "Error al insertar: $conexion->error"];
        }
    }
}