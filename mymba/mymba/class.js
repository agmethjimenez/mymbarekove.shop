class pedido{
    constructor(idPedido, cliente, direccion, fecha, estado){
        this.idPedido = idPedido;
        this.cliente = cliente;
        this.direccion = direccion;
        this.fecha = fecha;
        this.estado = estado;
        this.detalle = [];
    }
    obtenerTotal(){

    }

    cancelar(){

    }
    obtenerDireccion(){

    }
}

class producto{
    constructor(idProducto, proveedor, nombre, descripcion, precio, marca, contenido, categoria){
        this.idProducto = idProducto;
        this.proveedor = proveedor;
        this.nombre = nombre;
        this.descripcion = descripcion;
        this.precio = precio;
        this.marca = marca;
        this.contenido = contenido;
        this.categoria = categoria;
    }

    verInformacion(){

   }
    calcularPrecio(){

   }
}

class categoriaProducto{
    constructor(idCategoria, nombre, descripcion){
        this.idCategoria = idCategoria;
        this.nombre = nombre;
        this.descripcion = descripcion;
        this.productos = [];
    }
    agregarProducto(){
     this.productos.push(idProducto)
    }
    eliminarProducto(){

    }

}