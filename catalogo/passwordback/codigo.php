<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();

if(isset($_GET['email']) && isset($_GET['token'])){
    $email = $_GET['email'];
    $token = $_GET['token'];

}else{
    header("Location: ../login.php ");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="../css/login.css">
    <title>Recuperar contraseña</title>

</head>
<body>
    <div class="container">
    <div class="container">
      <form action="cambio.php" method="POST">
        <div class="logo">
          <h1>Recuperar contraseña</h1>
          <img src="../imgs/Logo veterinaria animado azul rosado.png" alt="" />
        </div>
        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input class="input" type="text" name="codigo" placeholder="Codigo" required/>
            <span class="icon is-small is-left">
            <i class="fas fa-arrow-up-9-1"></i>
            </span>
          </p>
        </div>
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <div class="field">
          <p class="control">
            <input type="submit" name="submit" value="Enviar" />
          </p>
        </div>
      </form>
      
    </div>
    </div>
</body>
</html>