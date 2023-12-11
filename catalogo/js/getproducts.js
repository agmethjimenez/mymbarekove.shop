const url = 'http://localhost/mymbarekove.shop/controller/producto.php';
function mostrarProductos(categoria){
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
    productosFiltrados.forEach(producto => {
      let divproducto = document.createElement("div");
      divproducto.className = "producto";
      divproducto.innerHTML = `<img src="./imgs/productos/${producto.imagen}" alt="">
      <div class="informacion">
      <p>${producto.nombre}</p>
            <p class="precio">$${producto.precio} </p>
            <button class="comprar" onclick="agregarAlCarrito('${producto.nombre}',${producto.precio},'${producto.idProducto}',1,'${producto.imagen}')">Comprar</button>
            <button class="detalles" id="detalles"><a href="../catalogo/paginaproducto.php?id=${producto.idProducto}" class="dety">Detalles</a></button>
            </div>`;
      
      // Agregar el divproducto al contenedor
      div.append(divproducto);
    });
  })
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });
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
  mostrarProductos("Higiene y Cuidado");
});


