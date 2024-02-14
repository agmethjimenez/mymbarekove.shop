<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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
            <input class="input" type="email" name="email" placeholder="Email" required/>
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
      if(isset($_POST['email'])){
      $email = $_POST['email'];
      $sql = "SELECT*FROM credenciales WHERE email = ?";
      $bin = $conexion->prepare($sql);
      $bin->bind_param("s",$email);
      $bin->execute();
      $result = $bin->get_result();
      $token = bin2hex(random_bytes(16));
      #$token = str_pad($token, strlen($token) + (strlen($token) % 2), '0', STR_PAD_LEFT);

      if ($result->num_rows > 0){
        require_once 'mailreset.php';
        if($enviado){
            $sql2 = "UPDATE credenciales SET token = ?, codigo = ?, fecha_cambio = NOW() WHERE email = ?";
            $bin2 = $conexion->prepare($sql2);
            $bin2->bind_param("sss",$token,$codigo,$email);
            if($bin2->execute()){
                echo '<script>alert("Verifica tu correo")</script>';
            }else{
                echo $conexion->error;
            }

        }
      }else{
        echo '<div class="message is-danger" id="message">';
        echo '<p>Correo no encontrado</p>';
        echo '</div>';
      }
    }
      ?>
      </form>
      
    </div>
    </div>
</body>
</html>