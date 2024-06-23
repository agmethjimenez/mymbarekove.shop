<?php
include '../../config.php';
include '../../models/Http.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="../css/login.css">
  <title>Recuperar contraseña</title>

</head>

<body>
  <div class="container">
    <div class="container">
      <form action="solicitar.php" method="POST">
        <div class="logo">
          <h1>Recuperar contraseña</h1>
          <img src="../imgs/Logo veterinaria animado azul rosado.png" alt="" />
        </div>
        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input class="input" type="email" name="email" placeholder="Email" required />
            <span class="icon is-small is-left">
              <i class="fas fa-envelope"></i>
            </span>
          </p>
        </div>
        <div class="field">
          <p class="control">
            <input type="submit" name="submit" value="Enviar" />
          </p>
          <p>Ten encuenta que una vez enviado el codigo al correo solo tendra validez 30 minutos</p>
        </div>
        <?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    HttpClient::setUrl(URL.'/clave/restaurar');
    HttpClient::setBody(["email" => $email]);
    $enviarCorreo = HttpClient::post();

    if (isset($enviarCorreo['status']) && $enviarCorreo['status']) {
        echo "<script>alert('" . addslashes($enviarCorreo['mensaje']) . "');</script>";
    } else {
        $mensaje = isset($enviarCorreo['mensaje']) ? $enviarCorreo['mensaje'] : 'Error desconocido';
        echo "<script>alert('" . addslashes($mensaje) . "');</script>";
        }
    }

?>

      </form>

    </div>
  </div>
</body>

</html>