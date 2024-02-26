let carritoProductos =   JSON.parse(localStorage.getItem("carritoProductos"));

function EnviarDatosCarrito() {
    let sumaTotal = 0;
    for (let i = 0; i < carritoProductos.length; i++) {
       sumaTotal += carritoProductos[i].total;  
    }
    let datos = {
        detalles: carritoProductos,
        totalp: sumaTotal
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