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
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="./css/registro.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Formulario de Registro</title>
  </head>
  <body>
    <div class="container">
      <form action="" method="POST" onsubmit="validar()">
        <div class="tittle"><h1>Registro</h1></div>
        <div class="con1">
          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input
                class="input"
                type="text"
                name="nombre1"
                id="nombre1"
                placeholder="Primer nombre"
                required
                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]*"
              />
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input
                class="input"
                type="text"
                placeholder="Segundo nombre"
                name="nombre2"
                id="nombre2"
                required
                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]*"
              />
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="con2">
          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input
                class="input"
                type="text"
                placeholder="Primer apellido"
                name="apellido1"
                id="apellido1"
                required
                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]*"
              />
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input
                class="input"
                type="text"
                placeholder="Segundo apellido"
                name="apellido2"
                id="apellido2"
                required
                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]*"
              />
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="con3">
          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <div
                class="select"
                id="tipoIdentificacion"
                name="tipoIdentificacion"
              >
                <select
                  name="tipoIdentificacion"
                  id="tipoIdentificacion"
                  required
                >
                  <option value="">Tipo de ID</option>
                  <option value="1">Cédula de Ciudadanía</option>
                  <option value="2">Cedula Extranjeria</option>
                  <option value="4">PEP</option>
                  <option value="3">PASAPORTE</option>
                </select>
              </div>
              <div class="icon is-small is-left">
                <i class="fa-solid fa-rectangle-list"></i>
              </div>
            </div>
          </div>
          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input
                class="input"
                type="text"
                placeholder="Identificacion"
                name="identificacion"
                id="identificacion"
                required
                pattern="^[0-9]+$"
                title="Solo numeros"
                minlength="7"
                maxlength="10"
              />
              <span class="icon is-small is-left">
                <i class="fa-solid fa-id-card"></i>
              </span>
            </div>
            <div class="field is-horizontal">
              <div class="field-body"></div>
            </div>
          </div>
        </div>

        <div class="con4">
          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input
                class="input"
                type="text"
                placeholder="Telefono"
                name="telefono"
                id="telefono"
                required
                pattern="[0-9]{10}"
                title="El numero telefonico debe ser de 10 digitos"
              />
              <span class="icon is-small is-left">
                <i class="fas fa-phone"></i>
              </span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input class="input" type="email" placeholder="Email" name="email" id="email" required pattern="[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+"/>
              <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="con5">
          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input class="input" type="password" placeholder="Contraseña" name="password" id="password" required/>
              <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
              </span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left has-icons-right">
              <input class="input" type="password" placeholder="Confirmar contraseña" name="password2" id="confirmPassword" required/>
              <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="g-recaptcha" data-sitekey="6LelmxwpAAAAAFS3KlCNxJf9TfDpe70SP2y0Ie3w"></div>

        <div class="boton">
          <input type="submit"id="submit" value="Registrarse"/>
        </div>
        <?php
require_once("../models/Usuarios.php");
include_once("../database/conexion.php");
if(isset($_POST['identificacion'], $_POST['tipoIdentificacion'], $_POST['nombre1'], $_POST['nombre2'],
         $_POST['apellido1'], $_POST['apellido2'], $_POST['email'], $_POST['telefono'], $_POST['password'], $_POST['password2'])) {
$id_usuario = $_POST['identificacion'];
$cod_id = $_POST['tipoIdentificacion'];
$primernombre = $_POST['nombre1'];
$segundonombre = $_POST['nombre2'];
$primerapellido = $_POST['apellido1'];
$segundoapellido = $_POST['apellido2'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['password'];
$contraseña2 = $_POST['password2'];
  $usuario = new Usuario();
  $usuario->registrarse($id_usuario, $cod_id, $primernombre, $segundonombre, $primerapellido, $segundoapellido,$telefono, $email, $contrasena);
}


?>
        <p class="error" id="error"></p>
      </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="registro.js"></script>
    <script>
      function validar(){

      var respuestaRecaptcha = grecaptcha.getResponse();
      let password1 = document.getElementById("password").value;
      let password2 = document.getElementById("confirmPassword").value;
      let error = document.getElementById("error");

      error.innerHTML=""

      if (respuestaRecaptcha.length === 0) {
      alert("Por favor, completa la validación reCAPTCHA.");
      event.preventDefault();
      return false;
    }

      return true
      }

    </script>
  </body>
</html>
