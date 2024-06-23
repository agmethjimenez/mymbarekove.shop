
let carritoProductos =   JSON.parse(localStorage.getItem("carritoProductos")) || [];



function EnviarDatosCarrito() {
    let carritoProductos = JSON.parse(localStorage.getItem("carritoProductos"));
    if (!carritoProductos) return false; // Verificar si el carrito existe

    let sumaTotal = 0;
    for (let i = 0; i < carritoProductos.length; i++) {
       sumaTotal += carritoProductos[i].total;  
    }
    let datos = {
        detalles: carritoProductos,
    };
    fetch('guardar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Manejar la respuesta del servidor si es necesario
        return false; // Devolver false después de manejar la respuesta
    })
    .catch(error => {
        console.error('Error en la solicitud fetch:', error);
        return false; // Devolver false en caso de error
    });
}

EnviarDatosCarrito();
numerito();
function agregarAlCarrito(nombre, precio, id, cantidad = 1, imagen, stock) {
  const productoExistente = carritoProductos.find((producto) => producto.nombre === nombre);

  if (productoExistente) {
    const cantidadTotal = productoExistente.cantidad + cantidad;
    if (cantidadTotal > stock) {
      alert(`¡No hay suficiente stock disponible para agregar ${cantidad} unidades de ${nombre} al carrito!`);
      return;
    }
    if (cantidadTotal > 4) {
      alert("¡No se pueden agregar más de 4 unidades de un mismo producto al carrito!");
      return;
    }
    productoExistente.cantidad = cantidadTotal;
    productoExistente.total = productoExistente.precio * cantidadTotal;
  } else {
    if (cantidad > 4) {
      alert("¡No se pueden agregar más de 4 unidades de un mismo producto al carrito!");
      return;
    }
    if (cantidad > stock) {
      console.log(`¡No hay suficiente stock disponible para agregar ${cantidad} unidades de ${nombre} al carrito!`);
      return;
    }
    carritoProductos.push({
      imagen,
      id,
      nombre,
      precio,
      stock,
      cantidad,
      total: precio * cantidad
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
    const cantidadTotal = producto.cantidad + 1;
    if (cantidadTotal > producto.stock) {
      alert(`¡No hay suficiente stock disponible para agregar más unidades de ${producto.nombre} al carrito!`);
      return;
    }
    if (cantidadTotal > 4) {
      alert("¡No se pueden tener más de 4 unidades de un mismo producto en el carrito!");
      return;
    }
    producto.cantidad = cantidadTotal;
    producto.total = producto.cantidad * producto.precio;
    savelocal();
    tablear();
    EnviarDatosCarrito();
    
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

