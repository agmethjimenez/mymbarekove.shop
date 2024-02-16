let carritoProductos =   JSON.parse(localStorage.getItem("carritoProductos")) || [];
numerito();
function agregarAlCarrito(nombre, precio, id, cantidad = 1, imagen) {
  const productoExistente = carritoProductos.find((producto) => producto.nombre === nombre);

  if (productoExistente) {
    productoExistente.cantidad += cantidad;
    productoExistente.total = productoExistente.precio * productoExistente.cantidad;
  } else {
    carritoProductos.push({
      imagen,
      id,
      nombre,
      precio,
      cantidad,
      total:precio*cantidad
    });
    console.log(carritoProductos);
  }
  numerito();
  savelocal();
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

  carritoProductos.forEach((producto) => {
    if (carritoItems[producto.nombre]) {
      carritoItems[producto.nombre].cantidad += producto.cantidad;
      carritoItems[producto.nombre].total += producto.total;
      savelocal();
    } else {
      carritoItems[producto.nombre] = {
        imagen: producto.imagen,
        nombre: producto.nombre,
        precio: producto.precio,
        cantidad: producto.cantidad,
        total: producto.total
      };
    }
  });

  // Mostrar los productos y su cantidad en el carrito
  Object.values(carritoItems).forEach((item) => {
    const itemDiv = document.createElement("div");
    itemDiv.classList.add("carrito-item");
    itemDiv.innerHTML = `
    <div>
    
      <p><img src="./imgs/productos/${item.imagen}" alt="" width="50px">${item.nombre} - Cantidad: ${item.cantidad} - Precio: $${
      item.total
    }</p></div>
    <div>
      <button class="carrito-quitar" data-nombre="${item.nombre}">x</button>
      </div>
    `;
    carritoContenido.appendChild(itemDiv);
  });

  const total = carritoProductos.reduce(
    (acc, producto) => acc + producto.total,
    0
  );
  const totalDiv = document.createElement("div");
  totalDiv.classList.add("carrito-total");
  totalDiv.innerHTML = `
  <div>Total: $${total}</div><a href="pagina_de_pago.php" class="button is-black">Realizar pedido</a>`;
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
  numerito();
}
// Agregamos el evento click para abrir el contenedor flotante al hacer clic en la imagen de clase "carrito"
document.querySelector(".carrito").addEventListener("click", () => {
  mostrarCarrito();
  numerito()
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
      savelocal();
      mostrarCarrito(); 
      numerito();// Actualizamos el contenido del carrito
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

  const savelocal = ()=>{
    localStorage.setItem("carritoProductos", JSON.stringify(carritoProductos));
  }

  function numerito() {
    let divNumero = document.getElementById("addcart");
    let numCarrito = document.getElementById("numcarrito");

    let numeroAEstablecer = carritoProductos.length;

    numCarrito.innerText = numeroAEstablecer;

    divNumero.style.display = numeroAEstablecer > 0 ? 'flex' : 'none';
}
  


  function EnviarDatosenvio() {
let sumaTotal = 0;
for (let i = 0; i < carritoProductos.length; i++) {
   sumaTotal += carritoProductos[i].total;  
}
let cciudad = document.getElementById("ciudades").value;
let tipodireccion = document.getElementById("tipocarrera").value;
let calle = document.getElementById("calle").value;
let numerodireccion1 = document.getElementById("numero1").value;
let numerodireccion2 = document.getElementById("numero2").value;
let home = document.getElementById("home").value;
let direccionreal = `${tipodireccion} ${calle} #${numerodireccion1}-${numerodireccion2} ${home}`;
let datos = {
    ciudad: cciudad,
    direccion: direccionreal,
    detalles: carritoProductos,
    totalp: sumaTotal
};
fetch('http://localhost/mymbarekove.shop/controller/pedido.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(datos),
})
    .then(response => response.json())
    .then(data => {
        if (data.exito) {
            alert('PEDIDO EXITOSO: ' + data.mensaje);
            document.getElementById("form").reset();
        } else {
            alert('ERROR EN EL PEDIDO: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud fetch:', error);
    });
    return false;
}

