<?php
require_once("../database/conexion.php");
class Producto
{
    private $id_producto;
    private $nombre;
    private $descripcion;
    private $precio;
    private $marca;
    private $categoria;
    private $proveedor;
    private $contenido;
    private $stock;
    private $imagen;

    public function setIdProducto($id){
        $this->id_producto = $id;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    public function setMarca($marca){
        $this->marca = $marca;
    }
    public function setProveedor($provedor){
        $this->proveedor = $provedor;
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }
    public function setContenido($contenido){
        $this->contenido = $contenido;
    }
    public function setStock($stock){
        $this->stock = $stock;
    }
    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

    public function GetProductos($conexion, $id, $busqueda, $categoria) {
        if ($id === null) {
            if ($busqueda !== null) {
                $sql = "SELECT p.idProducto, pr.nombreP, p.nombre, p.descripcionP, p.contenido, p.precio, m.marca, c.descripcion, p.cantidadDisponible, p.imagen 
                        FROM productos AS p 
                        INNER JOIN proveedores AS pr ON p.proveedor = pr.idProveedor
                        INNER JOIN marcas AS m ON p.marca = m.idMarca
                        INNER JOIN categorias AS c ON p.categoria = c.categoria
                        WHERE p.activo = 1 AND p.nombre LIKE '%$busqueda%'";
            } else if ($categoria !== null) {
                $sql = "SELECT p.idProducto, pr.nombreP, p.nombre, p.descripcionP, p.contenido, p.precio, m.marca, c.descripcion, p.cantidadDisponible, p.imagen 
                        FROM productos AS p 
                        INNER JOIN proveedores AS pr ON p.proveedor = pr.idProveedor
                        INNER JOIN marcas AS m ON p.marca = m.idMarca
                        INNER JOIN categorias AS c ON p.categoria = c.categoria
                        WHERE p.activo = 1 AND p.categoria = $categoria";
            } else {
                $sql = "SELECT p.idProducto, pr.nombreP, p.nombre, p.descripcionP, p.contenido, p.precio, m.marca, c.descripcion, p.cantidadDisponible, p.imagen 
                        FROM productos AS p 
                        INNER JOIN proveedores AS pr ON p.proveedor = pr.idProveedor
                        INNER JOIN marcas AS m ON p.marca = m.idMarca
                        INNER JOIN categorias AS c ON p.categoria = c.categoria
                        WHERE p.activo = 1";
            }
        } else {
            $sql = "SELECT p.idProducto, pr.nombreP, p.nombre, p.descripcionP, p.contenido, p.precio, m.marca, c.descripcion, p.cantidadDisponible, p.imagen 
                    FROM productos AS p 
                    INNER JOIN proveedores AS pr ON p.proveedor = pr.idProveedor
                    INNER JOIN marcas AS m ON p.marca = m.idMarca
                    INNER JOIN categorias AS c ON p.categoria = c.categoria
                    WHERE p.activo = 1 AND idProducto = $id";
        }
        
        $resultados = array();
    
        if ($resultado = $conexion->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $resultados[] = $fila;
            }
            $resultado->free();
        }
        return $resultados;
    }
    
    
    public function AgregarProducto($conexion){
        $id = rand(1000,9999);
        $sql = "INSERT INTO productos(idProducto,proveedor, nombre, descripcionP, contenido, precio, marca, categoria, cantidadDisponible, imagen,activo) VALUES (?,?,?,?,?,?,?,?,?,?,1)";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("ssssssssss",$this->id_producto,$this->proveedor,$this->nombre,$this->descripcion,$this->contenido,$this->precio, $this->marca, $this->categoria, $this->stock,$this->imagen);
        if($bin->execute()){
            return["accesso"=>true,"mensaje"=>"Producto Agregado exitosamente"];
        }else{
            return["accesso"=>false,"mensaje"=>"Producto no agregado","error"=>$conexion->error];
        }
    }
    public function ActualizarProducto($conexion){
        $sql = "UPDATE productos SET nombre = ?, descripcionP = ?, contenido = ?, precio = ?, cantidadDisponible = ?, imagen = ? WHERE idProducto = ?";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("sssssss",$this->nombre,$this->descripcion,$this->contenido, $this->precio, $this->stock, $this->imagen,$this->id_producto);
        if($bin->execute()){
            return["accesso" => true, "mensaje" => "Producto Actualizado"];
        }else{
            return["accesso" => false, "mensaje" => "Producto no Actualizado"];
        }
        
    }
    public static function BuscarProducto($conexion, $nombreProducto){
        $query = "SELECT * FROM productos WHERE nombre LIKE ?";
    
        $stmt = $conexion->prepare($query);
        $nombreProducto = "%$nombreProducto%"; 
        $stmt->bind_param("s", $nombreProducto);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        $productos = array();
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        $stmt->close();
    
        return json_encode($productos);
    }
    
}

    

?>
