const url = 'http://localhost/mymbarekove.shop/controller/producto.php';
function mostrarProductos(categoria, terminoDeBusqueda = ""){
fetch(url, {
  method: 'GET',
})
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    const productos = data;
    
    const div = document.getElementById("contenedor");
   div.innerHTML = "";
    const productosFiltrados = (categoria === 'todos') ? productos : productos.filter(producto => producto.categoria === categoria);
    const productosFiltradosPorBusqueda = productosFiltrados.filter(producto => producto.nombre.toLowerCase().includes(terminoDeBusqueda.toLowerCase()));
  
    if (productosFiltradosPorBusqueda.length === 0) {
      const mensajeNoDisponible = document.createElement("h1");
      mensajeNoDisponible.innerHTML = "Producto no encontrado";
      div.append(mensajeNoDisponible);
  } else {
      // Mostrar productos filtrados
      productosFiltradosPorBusqueda.forEach(producto => {
          let divproducto = document.createElement("div");
          const formatoDolares = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP', 
            minimumFractionDigits: 0, 
          });
          const precioFormateado = formatoDolares.format(producto.precio);


          divproducto.className = "producto";
          divproducto.innerHTML = `<a href="../catalogo/paginaproducto.php?id=${producto.idProducto}"><img src="${producto.imagen}" alt=""></a>
          <div class="informacion">
          <a id="nombreproducto" href="../catalogo/paginaproducto.php?id=${producto.idProducto}">${producto.nombre}</a>         
          <p class="precio">${precioFormateado} </p>       
          <button class="comprar" onclick="agregarAlCarrito('${producto.nombre}',${producto.precio},'${producto.idProducto}',1,'${producto.imagen}')">Agregar <i class="fa-solid fa-cart-plus fa-lg"></i></button>
          </div>`;
      
          div.append(divproducto);
      });
  }

  })
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });
}
function buscarProductos() {
  const terminoDeBusqueda = document.getElementById("searchin").value;
  mostrarProductos("todos", terminoDeBusqueda);
}


mostrarProductos("todos");
document.getElementById("categoria-todos").addEventListener("click",()=>{
  mostrarProductos("todos")
});
document.getElementById("categoria-aseo").addEventListener("click",()=>{
  mostrarProductos("Aseo");
});
document.getElementById("categoria-alimento").addEventListener("click",()=>{
  mostrarProductos("Alimento");
});
document.getElementById("categoria-juguetes").addEventListener("click",()=>{
  mostrarProductos("Juguetes");
});
document.getElementById("categoria-medicamentos").addEventListener("click",function(){
  mostrarProductos("Medicamentos\r\n");
})
document.getElementById("categoria-accesorios").addEventListener("click",function(){
  mostrarProductos("Accesorios");
});
document.getElementById("categoria-higiene").addEventListener("click",function(){
  mostrarProductos("Higiene y Cuidado\r\n");
});


