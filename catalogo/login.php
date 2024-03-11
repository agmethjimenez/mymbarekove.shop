<?php
session_start();
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
require_once("../models/Administrador.php");
$conexion->set_charset("utf8");
if ((isset($_SESSION['id_usuario']) && isset($_SESSION['usuario_nombre']) && isset($_SESSION['usuario_apellido'])) ||
  (isset($_COOKIE['id_usuario']) && isset($_COOKIE['usuario_nombre']) && isset($_COOKIE['usuario_apellido']))
) {
  echo '<script>alert("Ya has iniciado sesión."); window.location.href = "catalogo.php";</script>';
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="./css/login.css" />

  <title>Login</title>
</head>

<body>
  <div class="container">
    <form action="" method="post" onsubmit="Loguear()">
      <div class="logo">
        <h1>Bienvenido</h1>
        <img src="imgs/Logo veterinaria animado azul rosado.png" alt="" />
      </div>
      <div class="field">
        <p class="control has-icons-left has-icons-right">
          <input class="input" type="email" name="email" id="email" placeholder="Email" required />
          <span class="icon is-small is-left">
            <i class="fas fa-envelope"></i>
          </span>
        </p>
      </div>
      <div class="field">
        <p class="control has-icons-left">
          <input class="input" type="password" id="password" name="password" placeholder="Contraseña" required />
          <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
          </span>
        </p>
      </div>
      <label class="checkbox">
        <input type="checkbox" name="check">
        I agree to the <a href="../terminos.php">terms and conditions</a>
      </label>
  
      <div class="field">
        <p class="control">
          <input type="submit" name="submit" value="Acceder" />
        </p>
      </div>

      <div>
        ¿Olvidaste tu contraseña?<a href="./passwordback/solicitar.php">Click aqui!</a>
      </div>
      <?php
if (!empty($_POST["submit"])) {
    if (!isset($_POST['check']) || $_POST['check'] != 'on') {
        echo '<script>event.preventDefault()</script>';
        echo '<div class="message is-danger" id="message">';
        echo '<p>Checkbox no marcado</p>';
        echo '</div>';
    } else {
        if (empty($_POST["email"]) || empty($_POST["password"])) {
            $error_message = "CAMPOS VACIOS";
        } else {
            $correo = $_POST["email"];
            $contraseña = $_POST["password"];

            $datos = array(
                "email" => $correo,
                "password" => $contraseña
            );
            $url = 'http://localhost/mymbarekove.shop/controller/login.php';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);

            curl_close($ch);

            $response = json_decode($response, true);

            if ($response['acceso']) {
                if ($response['tipo'] === 'admin') {
                    $_SESSION['id_admin'] = $response['data']['id_admin'];
                    $_SESSION['username'] = $response['data']['username'];
                    $_SESSION['email'] = $response['data']['email'];

                    echo "Inicio de sesión exitoso como administrador";
                    header("location: catalogo.php");
                } else if ($response['tipo'] === 'user') {
                    $_SESSION['id_usuario'] = $response['data']['id'];
                    $_SESSION['usuario_nombre'] = $response['data']['nombre'];
                    $_SESSION['usuario_apellido'] = $response['data']['apellido'];
                    $_SESSION['usuario_email'] = $response['data']['email'];

                    echo "Inicio de sesión exitoso como usuario";
                    header("location: catalogo.php");
                } else {
                    echo '<script>event.preventDefault()</script>';
                    echo '<div class="message is-danger" id="message">';
                    echo '<p>Usuario desconocido</p>';
                    echo '</div>';
                }
            } else {
                echo '<script>event.preventDefault()</script>';
                echo '<div class="message is-danger" id="message">';
                echo '<p>Error al iniciar Sesión</p>';
                echo '</div>';
            }
        }
    }
}
?>



    </form>
  </div>
  <script>
    /*function Loguear(){
        let correo = document.getElementById("email").value;
        let password = document.getElementById("password").value;

        let datos = {
          "email" : correo,
          "password": password
        }
        fetch('http://localhost/mymbarekove.shop/controller/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.acceso) {
                console.log(data.mensaje);
                alert("Iniciando....");
                <?php
                ?>
                window.location.href = 'catalogo.php';
            } else {
                console.error(data.mensaje);
                alert("Error al loguear usuario: " + data.mensaje);
                event.preventDefault();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("errorrr");
        });
        event.preventDefault();
    }  */
  </script>
</body>

</html>