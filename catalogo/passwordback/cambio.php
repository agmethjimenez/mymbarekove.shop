<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();


$correcto = false;

if(isset($_POST['codigo']) && isset($_POST['token']) && isset($_POST['email'])){
    $codigo = $_POST['codigo'];
    $email = $_POST['email'];
    $token = $_POST['token'];
    $sql = "SELECT * FROM credenciales WHERE email = ? AND token = ? AND codigo = ?";
    $bin = $conexion->prepare($sql);
    $bin->bind_param("sss",$email,$token,$codigo);
    $bin->execute();
    $result = $bin->get_result();
    
    if ($result->num_rows>0) {
    $row = $result->fetch_assoc();

    $sql2 = "SELECT * FROM credenciales WHERE email = ? AND token = ? AND codigo = ? AND TIMESTAMPDIFF(MINUTE, fecha_cambio, NOW()) < 30";
    $bin2 = $conexion->prepare($sql2);
    $bin2->bind_param("sss",$email,$token,$codigo);
    $bin2->execute();
    $result2 = $bin2->get_result();
    if($result2->num_rows>0){
      $correcto = true;
    }else{
      $correcto = false;
      $error = 'Codigo caducado';
    }
    }else{
        $correcto = false;
        $error = "No encontrado";
    }
}      
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
    <?php
    if($correcto){
    ?>
    <div class="container">
    <div class="container">
      <form action="validacion.php" method="POST">
        <div class="logo">
          <h1>Restablecer contraseña</h1>
          <img src="../imgs/Logo veterinaria animado azul rosado.png" alt="" />
        </div>
        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input class="input" type="password" name="password1" placeholder="Password" required/>
            <span class="icon is-small is-left">
              <i class="fas fa-lock"></i>
            </span>
          </p>
        </div>
        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input class="input" type="password" name="password2" placeholder="Password 2" required/>
            <span class="icon is-small is-left">
              <i class="fas fa-lock"></i>
            </span>
          </p>
        </div>
        <input type="hidden" name="email" value="<?php echo $email;?>">
        <div class="field">
          <p class="control">
            <input type="submit" name="submit" value="Cambiar" />
          </p>
        </div>
      </form>
      
    </div>
    </div>
    <?php
    }else{
      echo '<div class="message is-danger" id="message">';
      echo "<p>$error</p>";
      echo '<a href="solicitar.php" class="button is-danger">Vuelve a intentarlo</a>';
      echo '</div>';
        

    }?>
</body>
</html>