
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://www.paypal.com/sdk/js?client-id=AXQFJwWBjQV3Hj3-eoEAIsMnkeihyoXhn_ejJSSvEN-2J0Dboodk93HqtbgaH9kMjAfJu8wYUm3VA7oE"></script>

    <link rel="stylesheet" href="pago.css">
    <title>Metodo pago</title>
</head>
<body>
<?php
//session_start();
include_once("header.php");
if ((!isset($_SESSION['usuario_nombre']) || !isset($_SESSION['usuario_apellido']) || !isset($_SESSION['id_usuario'])) &&
    (!isset($_COOKIE['usuario_nombre']) || !isset($_COOKIE['usuario_apellido']) || !isset($_COOKIE['id_usuario']))) {
    header("Location: login.php");
    exit();
}
?>

    <div class="tittle">
        <h1>Carrito de compras</h1>
    </div>
    <div class="container">
    <div class="cart">
        <div class="tablecontainer">
        <table class="table is-fullwidth is-striped is-hoverable" id="tablecart">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
            <tbody>
                <!-- Las filas de la tabla se agregarán dinámicamente con JavaScript -->
            </tbody>
        </table>
        </div>
        <div class="options" id="options"></div>

    </div>
    <div class="wrap">
    <?php
    if (!isset($_SESSION['direccion']) && !isset($_SESSION['ciudad'])) {
    
    ?>
    <form id="form" action="" method="POST">
        <h1 class="title">Informacion Pedido</h1>
        <div class="select">
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
<div class="select"> 
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
            <input type="text" class="input" name="calle" id="calle" placeholder="ej: 22 bis" required>
            <i class="fa-solid fa-hashtag"></i>
       <input type="text" class="input" name="numero1" id="numero1" placeholder="#" required>
       <i class="fa-solid fa-minus"></i>
       <input type="text" class="input" name="numero2" id="numero2" placeholder="-" required>
       </div>   
       <input type="text" class="input" name="home" id="home" placeholder="Torre/Apto-Casa" >
       <button type="submit"  name="checkdirection" class="button is-black">Añadir Direccion</button>
       
    


       
    </form>
    <?php
    if (isset($_POST['checkdirection'])) {
        $ciudad = $_POST['ciudades'];
        $tipo_calle = $_POST['tipocarrera'];
        $calle = $_POST['calle'];
        $num1 = $_POST['numero1'];
        $num2 = $_POST['numero2'];
        $home = $_POST['home'];

        $direccion = $tipo_calle . " " . $calle . " #" . $num1 . " -" . $num2 . " " . $home;
        $_SESSION['ciudad'] = $ciudad;
        $_SESSION['direccion'] = $direccion;

        echo '<script>alert("Dirección guardada correctamente.");</script>';
        echo '<script>location.reload();</script>';

        }
    ?>
    <?php } 
    if (isset($_SESSION['direccion']) && isset($_SESSION['ciudad']) && isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    ?>
    <div class="mp">
    <p>Seras dirigido a mercado pago para realizar el pago del pedido</p>
    <a href="checkout.php" class="button is-info is-outlined" style="width: 200px;">Realizar Pago</a>
    </div>
    <?php } ?>
</div>

        
</div>
</body>


<script src="https://www.paypal.com/sdk/js?client-id=AXQFJwWBjQV3Hj3-eoEAIsMnkeihyoXhn_ejJSSvEN-2J0Dboodk93HqtbgaH9kMjAfJu8wYUm3VA7oE&currency=COP"></script>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script src="carrito.js"></script>

<script>
    function vaciarCarrito() {
  localStorage.removeItem("carritoProductos");
  <?php
  unset($_SESSION['carrito']);
  ?>
  location.reload();
  tablear();
}
function tablear() {
    let productos = JSON.parse(localStorage.getItem("carritoProductos"));
    let tbody = document.getElementById("tablecart");
    let options = document.getElementById("options");
    tbody.innerHTML = "";
    options.innerHTML = "";
    let totalP = 0;

    if (!productos || productos.length === 0) {
        // Si no hay productos, mostrar mensaje y botón de redirección
        let noProductosMessage = document.createElement("div");
        noProductosMessage.className = 'noproduct'
        noProductosMessage.id = 'noproduct';
        noProductosMessage.innerHTML = `
        <p>No hay productos<p>
        <a href="catalogo.php">Ir al catalogo<a/>`;

        options.appendChild(noProductosMessage);

        
    } else {
        // Si hay productos, llenar la tabla y mostrar total y botón de vaciar carrito
        let thead = document.createElement("thead");
        thead.innerHTML = `
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Action</th>
            </tr>`;
        tbody.appendChild(thead);

        productos.forEach((product) => {
            totalP += product.total;
            const formatoDolares = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP', 
            minimumFractionDigits: 0, 
          });
          const precioFormateado = formatoDolares.format(product.precio);
          const total1 = formatoDolares.format(product.total);

            let row = document.createElement("tr");
            row.innerHTML = `
                <td><img src="${product.imagen}" alt="" width="50px"></td>
                <td>${product.nombre}</td>
                <td>${precioFormateado}</td>
                <td>
                    <button class="button is-black" id="botonmas" onclick="sumarCantidad('${product.id}')">+</button>
                    ${product.cantidad}
                    <button class="button is-black" id="botonmenos" onclick="restarCantidad('${product.id}')">-</button>
                </td>
                <td>${total1}</td>
                <td><button class="button is-black" id="botonquitar" onclick="eliminarProducto('${product.id}')"><i class="fa-solid fa-trash"></i></button></td>
            `;

            tbody.appendChild(row);
        });

        let divtotalyvaciar = document.createElement("div");
        const formatoDolares = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP', 
            minimumFractionDigits: 0, 
          });
        const TotalFormateado = formatoDolares.format(totalP);
        divtotalyvaciar.innerHTML = `
            <p>Total: ${TotalFormateado}</p>
            <a href="catalogo.php" class="button is-black" id="addmas">Productos</a>
            <button class="button is-danger" id="vaciar" onclick="vaciarCarrito()"><i class="fa-solid fa-trash-can"></i>Vaciar Carrito</button>`;
        options.appendChild(divtotalyvaciar);
    }
}
    tablear();
    

    
</script>


</html>
