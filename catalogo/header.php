
<head>
<?php
session_start(); 
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="./css/estilo.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="imgs/productos/Copia de Logo veterinaria animado azul rosado.png">
</head>
<header>
    <div class="logo-container">
      <img class="logo" src="imgs/productos/Copia de Logo veterinaria animado azul rosado.png" alt="Logo">
    </div>
    <div class="ssa" style="display: flex; justify-content: center; align-items: center;">
    <form action="search.php" method="GET">
        <input class="input is-primary" id="searchin" type="search" name="producto" placeholder="¿Qué producto buscas">
    </form>
</div>
        

    <nav class="navigation">
      <div class="cart-container">
        <a class="carrito" id="carrito" href="pagina_de_pago.php" style="color: black;">
        <i class="fa-solid fa-cart-shopping fa-2xl"></i>        </a>
        <div class="addcart" id="addcart">
          <p id="numcarrito" style="color: white;"></p>
        </div>
        <!--<div id="carritoFlotante" class="carrito-flotante">
          <div class="car-head">
            <h1>CARRITO DE COMPRAS</h1>
            <span id="carrito-cerrar">X</span>
          </div>
          <div class="carrito-contenido" id="carritoContenido"></div>

        </div>-->
      </div>
      <label for="menu-toggle" class="menu-icon">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </label>
      <input type="checkbox" id="menu-toggle">
      <nav class="nav2">

        <a class="infoin" href="../index.php"></i>Inicio</a>
        <?php
        if (isset($_SESSION['id_admin']) && isset($_SESSION['username'])) {
            $idAdministrador = $_SESSION['id_admin'];
            $usernameAdministrador = $_SESSION['username'];

            setcookie('admin_id', $idAdministrador, time() + 3600, '/');
            setcookie('admin_username', $usernameAdministrador, time() + 3600, '/');

            echo '<span id="admin" class="tag is-link is-light is-medium"><i class="fa-solid fa-screwdriver-wrench"></i><a id="abrir-panel">Panel</a></span>';
            echo '<span id="admin" class="tag is-danger is-medium"><i class="fa-solid fa-circle-user fa-lg"></i><a href="../admin/admin_action/panel.php">' . $usernameAdministrador . '</a></span>';
            echo '<form action="./logout.php" method="post">';
            echo '<button type="submit" class="acceso">Salir</button>';
            echo '</form>';
        } 

        else if (
          (isset($_SESSION['usuario_nombre']) || isset($_COOKIE['usuario_nombre'])) && 
          (isset($_SESSION['usuario_apellido']) || isset($_COOKIE['usuario_apellido'])) && 
          (isset($_SESSION['id_usuario']) || isset($_COOKIE['id_usuario']))
      ) {
          // Asigna los valores de las sesiones o cookies a las variables locales
          $nombre = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : $_COOKIE['usuario_nombre'];
          $apellido = isset($_SESSION['usuario_apellido']) ? $_SESSION['usuario_apellido'] : $_COOKIE['usuario_apellido'];
          $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : $_COOKIE['id_usuario'];
      
          // Asigna el valor de la cookie a $_SESSION['id_usuario'] solo si no está definido
          $_SESSION['id_usuario'] = $_SESSION['id_usuario'] ?? $_COOKIE['id_usuario'] ?? null;
      
          // Actualiza las cookies con los valores actuales de las variables de sesión
          setcookie('id_usuario', $id_usuario, time() + 3600);
          setcookie('usuario_nombre', $nombre, time() + 3600, '/');
          setcookie('usuario_apellido', $apellido, time() + 3600, '/');
      
          // Muestra la información del usuario y el botón de salida
          //echo '<span class="tag is-link is-medium" id="user"><i class="fa-solid fa-circle-user fa-lg"></i><a href="perfil.php">' . $nombre . ' ' . $apellido . '</a></span> ';
          echo '<a href="perfil.php" style="color:black;"><i class="fa-solid fa-circle-user fa-2xl" style="color: #FFD43B;"></i></a>';
          echo '<form action="./logout.php" method="post">';
          echo '<button type="submit" class="acceso">Salir  <i class="fa-solid fa-right-from-bracket"></i></button>';
          echo '</form>';
      }else{
            echo '<button class="acceso"><a href="./login.php">Acceder</a></button>';
            echo '<button class="acceso"><a href="./registro.php">Registrarse</a></button>';
        }
        ?>
      </nav>
    </nav>

  </header>
  <script src="carrito.js"></script>
