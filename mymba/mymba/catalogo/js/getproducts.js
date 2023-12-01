const url = 'http://localhost/mymbarekove.shop/mymba/mymba/controller/producto.php';

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
    productos.forEach(producto => {
      let divproducto = document.createElement("div");
      divproducto.className = "producto";
      divproducto.innerHTML = `<img src="./imgs/productos/${producto.imagen}" alt="">
      <div class="informacion">
      <p>${producto.nombre}</p>
            <p class="precio">$${producto.precio} </p>
            <button class="comprar" onclick="agregarAlCarrito('${producto.nombre}', ${producto.precio})">Comprar</button>
            <button class="detalles" id="detalles"><a href="../catalogo/paginaproducto.php?id=${producto.idProducto}" class="dety">Detalles</a></button>
            </div>`;
      
      // Agregar el divproducto al contenedor
      div.append(divproducto);
    });
  })
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });


