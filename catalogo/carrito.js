
let carritoProductos =   JSON.parse(localStorage.getItem("carritoProductos")) || [];



function EnviarDatosCarrito() {
  let sumaTotal = 0;
  for (let i = 0; i < carritoProductos.length; i++) {
     sumaTotal += carritoProductos[i].total;  
  }
  let datos = {
      detalles: carritoProductos,
  };
  fetch('http://localhost/mymbarekove.shop/catalogo/guardar_carrito.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(datos),
  })
      .then(response => response.json())
      .catch(error => {
          console.error('Error en la solicitud fetch:', error);
      });
      return false;
  }
EnviarDatosCarrito();
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
  savelocal();
  numerito();
  EnviarDatosCarrito();
}




  function savelocal(){
    localStorage.setItem("carritoProductos", JSON.stringify(carritoProductos));
  }

  
  function numerito() {
    let divNumero = document.getElementById("addcart");
    let numCarrito = document.getElementById("numcarrito");

    let numeroAEstablecer = carritoProductos.length;

    numCarrito.innerText = numeroAEstablecer;
    divNumero.style.display = numeroAEstablecer > 0 ? 'flex' : 'none';
}
  

function sumarCantidad(id) {
  const producto = carritoProductos.find(item => item.id === id);

  if (producto) {
    producto.cantidad++;
    producto.total = producto.cantidad * producto.precio;
    console.log(`Se aumentó la cantidad de ${producto.nombre}. Cantidad actual: ${producto.cantidad}`);
    savelocal();
    tablear();
    EnviarDatosCarrito();
    
    // Otras acciones que desees realizar
  } else {
    console.log('Producto no encontrado en el carrito');
  }
}

// Función para restar la cantidad de un producto en el carrito
function restarCantidad(id) {
  const producto = carritoProductos.find(item => item.id === id);

  if (producto && producto.cantidad > 1) {
    producto.cantidad--;
    producto.total = producto.cantidad * producto.precio;
    console.log(`Se redujo la cantidad de ${producto.nombre}. Cantidad actual: ${producto.cantidad}`);
    savelocal();
    tablear();
    EnviarDatosCarrito();

  } else if (producto && producto.cantidad === 1) {
    console.log(`No se puede reducir más la cantidad de ${producto.nombre}.`);
  } else {
    console.log('Producto no encontrado en el carrito');
  }
}
function eliminarProducto(id) {
  const index = carritoProductos.findIndex(item => item.id === id);

  if (index !== -1) {
    const productoEliminado = carritoProductos.splice(index, 1)[0];
    console.log(`Se eliminó el producto ${productoEliminado.nombre} del carrito.`);
    savelocal();
    tablear();
    EnviarDatosCarrito();

  } else {
    console.log('Producto no encontrado en el carrito');
  }
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

alert(direccionreal);

let datos = {
    ciudad: cciudad,
    direccion: direccionreal,
    detalles: carritoProductos,
    totalp: sumaTotal
};
fetch('http://localhost/mymbarekove.shop/catalogo/success.php', {
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

