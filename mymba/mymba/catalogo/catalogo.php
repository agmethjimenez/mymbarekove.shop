<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo mymba</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>
<body>
<header>
    <div class="logo-container">
        <img class="logo" src="imgs/productos/Copia de Logo veterinaria animado azul rosado.png" alt="Logo">
      </div>
      <div class="field">
        <p class="control has-icons-left has-icons-left">
          <input class="input is-rounded" id="searchin"type="search" placeholder="¿Que producto buscas">
          <span class="icon is-small is-left">
            <i class="fas fa-search"></i>
          </span>
        </p>
      </div>
    
      <nav class="navigation">
        <div class="cart-container">
            <img class="carrito" src="imgs/productos/carshop.png" alt="carrito-compras">
            <div id="carritoFlotante" class="carrito-flotante">
              <div class="car-head">
              <h1>CARRITO DE COMPRAS</h1>
              <button class="carrito-cerrar" id="carrito-cerrar">X</button>
            </div>
              <div class="carrito-contenido" id="carritoContenido"></div>
              
            </div>
          </div>
          <label for="menu-toggle" class="menu-icon">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </label>
          <input type="checkbox" id="menu-toggle">
          <nav class="nav2">
           
        <a class="infoin" href="../index.html"></i>Inicio</a>
       <a class="infoin" href="https://www.instagram.com/mymbarekove/">Contáctanos</a>
       <?php
    // Verificar si el usuario ha iniciado sesión
    session_start();
    if (isset($_SESSION['usuario_nombre']) && isset($_SESSION['usuario_apellido'])) {
        $nombreUsuario = $_SESSION['usuario_nombre'];
        $apellidoUsuario = $_SESSION['usuario_apellido'];
        
        echo '<span class="tag is-primary is-medium" id="user">  <i class="fa-solid fa-circle-user fa-lg"></i>'  . $nombreUsuario . ' ' . $apellidoUsuario . '</span> ';
        echo '<form action="./logout.php" method="post">';
        echo '<button type="submit" class="acceso">Salir</button>';
        echo '</form>';
    } else {
       
        echo '<button class="acceso"><a href="./login.html">Acceder</a></button>';
        echo '<button class="acceso"><a href="./registro.html">Registrarse</a></button>';
    }
    ?>
          </nav> 
    </nav>
      
</header>

<div class="title1">
    <h1>Comida</h1>
    <p></p>
</div>
<div class="contenedor" name="contenedor"id="contenedor">
    <div class="producto">
        <img src="imgs/productos/purgante canisan 2,5ml.jpg" alt="producto1">
        <div class="informacion">
            <p>Purgante Canisan el mas vendido de todos</p>
            <p>⭐️⭐️⭐️⭐️⭐️</p>
            <p class="precio">$ 20000</p>
            <button class="comprar">Comprar</button>
            <button class="detalles" id="detalles" data-producto-id="1" onclick="abrirmodal()">Detalles</button>
        </div>
    </div>
    <div class="producto">
        <img src="imgs/productos/dog chow adulto raza pequeña 8kg.jpg" alt="producto2">
        <div class="informacion">
            <p>Dog Chow Raza pequeña</p>
            <p>⭐️⭐️⭐️⭐️⭐️</p>
            <p class="precio">$ 60000</p>
            <button class="comprar">Comprar</button>
            <button class="detalles" id="detalles" data-producto-id="2" onclick="abrirmodal()">Detalles</button>
        </div>
    </div>
    <div class="producto" id="producto">
        <img src="imgs/productos/2626_Smartbones_Pollo_Mini_8_Unidades_500X500.avif" alt="producto3">
        <div class="informacion">
            <p>Smartbones Pollo Mini x8</p>
            <p>⭐️⭐️⭐️⭐️⭐️</p>
            <p class="precio">$ 18090</p>
            <button class="comprar">Comprar</button>
            <button class="detalles" id="detalles" data-producto-id="3" onclick="abrirmodal()">Detalles</button>
        </div>
    </div>
    <div class="producto">
        <img src="imgs/productos/3606_61898_Royal_Canin_Fbn_Persian_Adult_1616613262_2176x2168.avif" alt="producto4">
        <div class="informacion">
            <p>Royal Canin-Persian Adult</p>
            <p>⭐️⭐️⭐️⭐️⭐️</p>
            <p class="precio">$ 152900</p>
            <button class="comprar">Comprar</button>
            <button class="detalles" id="detalles" data-producto-id="4" onclick="abrirmodal()">Detalles</button>
        </div>
    </div>
    <div class="producto">
        <img src="imgs/productos/80340_Pet_Spa___Rascador_Tipo_Ola_1658844444_0_500x500.avif" alt="producto5">
        <div class="informacion">
            <p>Rascador tipo ola</p>
            <p>⭐️⭐️⭐️⭐️⭐️</p>
            <p class="precio">$ 42000</p>
            <button class="comprar">Comprar</button>
            <button class="detalles" data-producto-id="5" id="detalles" onclick="abrirmodal()">Detalles</button>
        </div>
    </div>
</div>
<div id="modal" class="modal">
    </div>
</div>
<div class="footer">
    <div class="col-1">
        <h3>ENLACES</h3>
        <a href="#">Acerca de</a>
        <a href="#">Servicios</a>
        <a href="#">Tienda</a>
    </div>
    <div class="col-2">
        <h3>LO ULTIMO</h3>
        <form action="">
            <input type="text" class="text" placeholder="Ingrese su correo"><br>
            <button type="submit" class="submit">Suscribirse</button>
        </form>
    </div>
    <div class="col-3">
        <h3>CONTACTO</h3>
        <p>3124376338 <br>rekovesistem@mail.com</p>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="carrito.js"></script>
<script src="modal.js"></script>
</html>
