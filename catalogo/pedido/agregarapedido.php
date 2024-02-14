<?php
if (!isset($_GET['pedido'])) {
    header("Location: detallepedido.php");
    exit();
}

$idPedido = $_GET['pedido'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Document</title>
</head>
<body>
    <div class="contenedor" id="contenedor"></div>

    <script>
        const idPedido = "<?php echo $idPedido; ?>";
        const url = 'http://localhost/mymbarekove.shop/controller/producto.php';

        const agregarpedido = (idproducto, precio) => {
            const jsonData = {
                "idproducto": idproducto,
                "idPedido": idPedido,
                "precio": precio
            };

            fetch('http://localhost/mymbarekove.shop/catalogo/pedido/funcionagregar.php', {
                method: 'POST',
                headers: {
            'Content-Type': 'application/json',
                },
                body: JSON.stringify(jsonData),
                })
            .then(response => response.json())
            .then(data => {
                if (data.bien) {
                    alert('Producto agregado exitosamente');
                    window.location.href = 'detallepedido.php?id=' + idPedido;

                } else {
                    alert('Error al agregar el producto: ' + data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function mostrarProductos(categoria) {
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
              
                if (productosFiltrados.length === 0) {
                    const mensajeNoDisponible = document.createElement("h1");
                    mensajeNoDisponible.innerHTML = "Producto no encontrado";
                    div.append(mensajeNoDisponible);
                } else {
                    // Mostrar productos filtrados
                    productosFiltrados.forEach(producto => {
                        let divproducto = document.createElement("div");
                        divproducto.className = "producto";
                        divproducto.innerHTML = `<img src="../imgs/productos/${producto.imagen}" alt="">
                        <div class="informacion">
                        <p>${producto.nombre}</p>
                        <p class="precio">$${producto.precio} </p>
                        <button class="comprar" onclick="agregarpedido(${producto.idProducto},${producto.precio})">Agregar</button>
                        </div>`;
                    
                        div.append(divproducto);
                    });
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        }

        // Agregar un evento al cargar la página para obtener el id del pedido
        window.onload = function() {
            mostrarProductos("todos");
        };

        
    </script>
</body>
</html>
