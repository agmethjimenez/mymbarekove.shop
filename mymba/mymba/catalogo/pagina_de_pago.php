<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="pago.css">
    <title>Metodo pago</title>
</head>
<body>
    <?php 
    include_once("header.php");
    ?>
    <div class="container">
    <div class="cart">
        <table class="table is-fullwidth is-striped is-hoverable" id="tablecart">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Las filas de la tabla se agregarán dinámicamente con JavaScript -->
            </tbody>
        </table>
    </div>
    <div class="wrap">
    <form action="" id="form" onsubmit="EnviarDatosenvio()">
        <h1 class="title">Informacion Pedido</h1>
        <div class="select is-success">
        <select name="ciudades" id="ciudades" required>     
            <option value="" disabled selected>Ciudad</option>
            <option value="Bogota">Bogotá</option>
            <option value="Medellin">Medellín</option>
            <option value="Cali">Cali</option>
            <option value="Barranquilla">Barranquilla</option>
            <option value="Bello">Bello</option>
            <option value="Buga">Buga</option>
            <option value="Palmira">Palmira</option>
            <option value="Envigado">Envigado</option>
            <option value="Cartagena">Cartagena</option>
            <option value="Cucuta">Cúcuta</option>
            <option value="Soacha">Soacha</option>
            <option value="Manizales">Manizales</option>
            <option value="Pereira">Pereira</option>
</select> </div>
<div class="select is-success"> 
            <select name="tipocarrera" id="tipocarrera" required>
            <option value="" disabled selected>Tipo de direccion</option>
            <option value="Avenida">Avenida</option>
            <option value="Avenida Calle">Avenida Calle</option>
            <option value="Avenida Carrera">Avenida Carrera</option>
            <option value="Carrera">Carrera</option>
            <option value="Calle">Calle</option>
            <option value="Diagonal">Diagonal</option>
            <option value="Transversal">Transversal</option>
            <option value="Via">Via</option>
            </select></div> 
            <div class="numerodire">
            <i class="fa-solid fa-street-view"></i>
            <input type="text" class="input is-success" id="calle" placeholder="Numero" required>
            <i class="fa-solid fa-hashtag"></i>
       <input type="text" class="input is-success" id="numero1" placeholder="#" required>
       <i class="fa-solid fa-minus"></i>
       <input type="text" class="input is-success" id="numero2" placeholder="-" required>
       </div>   
       <input type="text" class="input is-success" id="home" placeholder="Torre/Apto-Casa" required>
       <button class="button is-success">Realizar Pedido</button>
    </form>
</div>

        
</div>
</body>
<script>
let productos = JSON.parse(localStorage.getItem("carritoProductos"));

let tbody = document.getElementById("tablecart"); // Cambié "thead" a "tbody"

productos.forEach((product) => {
    let row = document.createElement("tr"); // Cambié "div" a "tr"
    row.innerHTML = `
        <td><img src="./imgs/productos/${product.imagen}" alt="" width="50px"></td>
        <td>${product.nombre}</td>
        <td>$${product.precio}</td>
        <td>${product.cantidad}</td>
        <td>$${product.total}</td>
    `;

    tbody.appendChild(row); // Utiliza "appendChild" para agregar filas a tbody
});

</script>
<script src="carrito.js"></script>
</html>
