<?php
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

    public function GetProductos($conexion, $id = null, $busqueda = null, $categoria = null) {
        $sql = "SELECT p.idProducto, pr.nombreP, p.nombre, p.descripcionP, p.contenido, p.precio, m.marca, c.descripcion, p.cantidadDisponible, p.imagen
                FROM productos AS p
                INNER JOIN proveedores AS pr ON p.proveedor = pr.idProveedor
                INNER JOIN marcas AS m ON p.marca = m.idMarca
                INNER JOIN categorias AS c ON p.categoria = c.categoria
                WHERE p.activo = 1";
      
        $params = [];
      
        if ($id !== null) {
          $sql .= " AND p.idProducto = :id";
          $params[":id"] = $id;
        }
      
        if ($busqueda !== null) {
          $sql .= " AND p.nombre LIKE :busqueda";
          $params[":busqueda"] = "%$busqueda%";
        }
      
        if ($categoria !== null) {
          $sql .= " AND p.categoria = :categoria";
          $params[":categoria"] = $categoria;
        }
      
        try {
          $stmt = $conexion->prepare($sql);
          $stmt->execute($params);
          $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $resultado;
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          return false;
        }
      }
      
    
    
      public function AgregarProducto($conexion){
        $id = rand(1000, 9999);
    
        $sql = "INSERT INTO productos (idProducto, proveedor, nombre, descripcionP, contenido, precio, marca, categoria, cantidadDisponible, imagen, activo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
    
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $this->proveedor);
        $stmt->bindParam(3, $this->nombre);
        $stmt->bindParam(4, $this->descripcion);
        $stmt->bindParam(5, $this->contenido);
        $stmt->bindParam(6, $this->precio);
        $stmt->bindParam(7, $this->marca);
        $stmt->bindParam(8, $this->categoria);
        $stmt->bindParam(9, $this->stock);
        $stmt->bindParam(10, $this->imagen);
    
        if ($stmt->execute()) {
            return ["accesso" => true, "mensaje" => "Producto Agregado exitosamente"];
        } else {
            return ["accesso" => false, "mensaje" => "Producto no agregado", "error" => $stmt->errorInfo()[2]];
        }
    }
    
    public function ActualizarProducto($conexion){
        $sql = "UPDATE productos 
                SET nombre = ?, descripcionP = ?, contenido = ?, precio = ?, cantidadDisponible = ?, imagen = ? 
                WHERE idProducto = ?";
    
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->descripcion);
        $stmt->bindParam(3, $this->contenido);
        $stmt->bindParam(4, $this->precio);
        $stmt->bindParam(5, $this->stock);
        $stmt->bindParam(6, $this->imagen);
        $stmt->bindParam(7, $this->id_producto);
    
        if ($stmt->execute()) {
            return ["accesso" => true, "mensaje" => "Producto Actualizado"];
        } else {
            return ["accesso" => false, "mensaje" => "Producto no Actualizado"];
        }
    }
    
    public static function BuscarProducto($conexion, $nombreProducto){
        $query = "SELECT * FROM productos WHERE nombre LIKE :nombreProducto";
    
        $stmt = $conexion->prepare($query);
        $nombreProducto = "%$nombreProducto%"; 
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->execute();
    
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    
        return json_encode($productos);
    }
    
    
}

    

?>
