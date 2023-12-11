<?php
session_start();
require_once("../models/Usuarios.php");
require_once("../database/conexion.php");
require_once("../models/Administrador.php");
$conexion->set_charset("utf8");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <link rel="stylesheet" href="./css/login.css"/>

    <title>Document</title>
  </head>
  <body>
    <div class="container">
      <form action="login.php" method="POST">
        <div class="logo">
          <h1>Bienvenido</h1>
          <img src="imgs/Logo veterinaria animado azul rosado.png" alt="" />
        </div>
        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input
              class="input"
              type="email"
              name="email"
              placeholder="Email"
              required
            />
            <span class="icon is-small is-left">
              <i class="fas fa-envelope"></i>
            </span>
          </p>
        </div>
        <div class="field">
          <p class="control has-icons-left">
            <input
              class="input"
              type="password"
              name="password"
              placeholder="Contraseña"
              required
            />
            <span class="icon is-small is-left">
              <i class="fas fa-lock"></i>
            </span>
          </p>
        </div>
        <div>
          ¿No estas registrado?<a href="./registro.html"> !Hazlo ahora¡</a>
        </div>
        <div class="field">
          <p class="control">
            <input type="submit" name="submit" value="Acceder" />
          </p>
        </div>
        <?php  
      $error_message = "";
      if (!empty($_POST["submit"])) {
          if (empty($_POST["email"]) || empty($_POST["password"])) {
              $error_message = "CAMPOS VACIOS";
          } else {
              $correo = $_POST["email"];
              $contraseña = $_POST["password"];

              $admin = new Admin();
              $usuario = new Usuario();
              if ($admin->iniciarSesion($correo, $contraseña)) {
                exit();
            } else {
                $usuario = new Usuario();
                if ($usuario->inicioSesion($correo, $contraseña)) {
                    exit();
                }       
      }}}
      ?>


      </form>
    </div>
  </body>
</html>
