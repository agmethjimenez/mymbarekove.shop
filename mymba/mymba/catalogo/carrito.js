
let carritoProductos = [];

// Función para agregar un producto al carrito
function agregarAlCarrito(nombre, precio) {
  carritoProductos.push({nombre, precio});
  actualizarCarrito();
  const carritoFlotante = document.getElementById("carritoFlotante");
  if (carritoFlotante.style.display === "block") {
    mostrarCarrito();
  }
}

// Función para actualizar el contenido del carrito en el contenedor flotante
function mostrarCarrito() {
  const carritoContenido = document.getElementById("carritoContenido");
  carritoContenido.innerHTML = ""; // Limpiamos el contenido previo

  let carritoItems = {};

  // Contamos la cantidad de cada producto en el carrito
  carritoProductos.forEach((producto) => {
    if (carritoItems[producto.nombre]) {
      carritoItems[producto.nombre].cantidad++;
    } else {
      carritoItems[producto.nombre] = {
        nombre: producto.nombre,
        precio: producto.precio,
        cantidad: 1,
      };
    }
  });

  // Mostrar los productos y su cantidad en el carrito
  Object.values(carritoItems).forEach((item) => {
    const itemDiv = document.createElement("div");
    itemDiv.classList.add("carrito-item");
    itemDiv.innerHTML = `
    <div>
      <p>${item.nombre} - Cantidad: ${item.cantidad} - Precio: $${
      item.precio * item.cantidad
    }</p></div>
    <div>
      <button class="carrito-quitar" data-nombre="${item.nombre}">x</button>
      </div>
    `;
    carritoContenido.appendChild(itemDiv);
  });

  // Mostramos el total en el carrito flotante
  const total = carritoProductos.reduce(
    (acc, producto) => acc + producto.precio,
    0
  );
  const totalDiv = document.createElement("div");
  totalDiv.classList.add("carrito-total");
  totalDiv.innerHTML = `
  <div>Total: $${total}</div> <button class="button is-success is-outlined">Realizar pedido</button>`;
  carritoContenido.appendChild(totalDiv);

  // Mostramos el contenedor flotante
  document.getElementById("carritoFlotante").style.display = "block";
}

// Función para actualizar el contenido del carrito en la página principal
function actualizarCarrito() {
  const carritoNumero = document.getElementById("numero");
  carritoNumero.textContent = carritoProductos.length;
  
  if (carritoProductos) {
    const carritoNumero = document.getElementById("numero");
    carritoNumero.textContent = carritoProductos.length;
  } else {
    console.error("La variable carritoProductos no está definida.");
  }
}
// Agregamos el evento click para abrir el contenedor flotante al hacer clic en la imagen de clase "carrito"
document.querySelector(".carrito").addEventListener("click", () => {
  mostrarCarrito();
});

// Agregamos eventos para el botón de "Comprar" en cada producto
const botonesComprar = document.querySelectorAll(".informacion .comprar");
botonesComprar.forEach((boton) => {
  boton.addEventListener("click", () => {
    const productoDiv = boton.closest(".informacion");
    const nombreProducto =
      productoDiv.querySelector("p:first-child").textContent;
    const precioProducto = parseFloat(
      productoDiv.querySelector(".precio").textContent.slice(1)
    );
    agregarAlCarrito(nombreProducto, precioProducto);
  });
});

// Agregamos el evento click para quitar un producto del carrito
document
  .getElementById("carritoContenido")
  .addEventListener("click", (event) => {
    if (event.target.classList.contains("carrito-quitar")) {
      const nombreProducto = event.target.getAttribute("data-nombre");
      carritoProductos = carritoProductos.filter(
        (producto) => producto.nombre !== nombreProducto
      );
      mostrarCarrito(); // Actualizamos el contenido del carrito
      actualizarCarrito(); // Actualizamos el carrito en la página principal
    }
  });

// Función para ocultar el contenedor flotante al hacer clic en el botón de cerrar
document
  .getElementById("carritoFlotante")
  .addEventListener("click", (event) => {
    if (event.target.id === "carrito-cerrar") {
      document.getElementById("carritoFlotante").style.display = "none";
    }
  });
  console.log(carritoProductos);
  console.log(carritoContenido);
  console.log(carritoItems);
