<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<header>
    <div class="logo-container">
      <img class="logo" src="imgs/productos/Copia de Logo veterinaria animado azul rosado.png" alt="Logo">
    </div>
    <div class="field">
      <p class="control has-icons-left has-icons-left">
        <input class="input is-rounded" id="searchin" type="search" placeholder="¿Que producto buscas">
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
        session_start();
        if (isset($_SESSION['usuario_nombre']) && isset($_SESSION['usuario_apellido'])) {
          $nombreUsuario = $_SESSION['usuario_nombre'];
          $apellidoUsuario = $_SESSION['usuario_apellido'];

          echo '<span class="tag is-primary is-medium" id="user">  <i class="fa-solid fa-circle-user fa-lg"></i>'  . $nombreUsuario . ' ' . $apellidoUsuario . '</span> ';
          echo '<form action="./logout.php" method="post">';
          echo '<button type="submit" class="acceso">Salir</button>';
          echo '</form>';
        } else {

          echo '<button class="acceso"><a href="./login.php">Acceder</a></button>';
          echo '<button class="acceso"><a href="./registro.html">Registrarse</a></button>';
        }
        ?>
      </nav>
    </nav>

  </header>