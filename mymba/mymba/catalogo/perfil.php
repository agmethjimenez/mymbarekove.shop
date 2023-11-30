<?php
require_once("../database/conexion.php");
require_once("../models/Usuarios.php");
require_once("../controller/users.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./css/perfil.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="./js/perfil.js"></script>
    <title>Perfil</title>
</head>

<body>
    <?php
    session_start();
    $usuario = new Usuario();

    $id = $_SESSION['id_usuario'];
    $usuario->verDatos($id);
    ?>
    <div class="wrapper">

        <div class="is-one-third" id="options">
            <ul>
                <li><a id="verinfo">Ver Información</a></li>
                <li><a href="cambiarclave.php" id="cambiarclave">Cambiar Clave</a></li>
                <li><a id="actualizar">Actualizar Información</a></li>
                <li><a href="logout.php">Salir</a></li>
            </ul>
        </div>
        <div class="info" id="info">
            <h1 class="titulo">Perfil de Usuario</h1>
            <h1 class="tit"><strong>Identificacion</strong></h1>
            <p><?php echo $_SESSION['identificacion']; ?></p>
            <h1 class="tit"><strong>Nombres</strong></h1>
            <p><?php echo $_SESSION['nombre1'] . ' ' . $_SESSION['nombre2']; ?></p>
            <h1 class="tit"><strong>Apellidos</strong></h1>
            <p><?php echo $_SESSION['apellido1'] . ' ' . $_SESSION['apellido2']; ?></p>
            <h1 class="tit"><strong>Correo electronico</strong></h1>
            <p><?php echo $_SESSION['email']; ?></p>
            <h1 class="tit"><strong>Telefono</strong></h1>
            <p><?php echo $_SESSION['telefono']; ?></p>

        </div>

        <div class="actualizardatos" id="actualizardatos">
        <h1 class="titulo">Actualizar datos</h1>
        <p>*La identificacion y el tipo de identificacion no de pueden cambiar</p>
            <form method="post">
                <div class="con1">
                    <div>
                    <label class="label" for="">Primer Nombre</label>
                    <input class="input is-rounded" type="text" id="nombre1" name="nombre1" value="<?php echo $_SESSION['nombre1']; ?>"> 
                    </div>
                    <div>
                    <label class="label" for="">Segundo Nombre</label>
                    <input class="input is-rounded" type="text" id="nombre2" name="nombre2" value="<?php echo $_SESSION['nombre2'];?>">
                    </div>
                </div>
                <div class="con2">
                    <div>
                    <label class="label" for="">Primer apellido</label>
                    <input class="input is-rounded" type="text" id="apellido1" name="apellido1" value="<?php echo $_SESSION['apellido1'] ?>">
                    </div>
                    <div>
                    <label class="label" for="">Segundo apellido</label>
                    <input class="input is-rounded" type="text" id="apellido2" name="apellido2" value="<?php echo $_SESSION['apellido2'] ?>">
                    </div>
                </div>
                <div class="con3">
                    <div>
                    <label class="label" for="">Correo</label>
                    <input class="input is-rounded" type="text" id="email" name="email" value="<?php echo $_SESSION['email'] ?>">
                    </div>
                    <div>

                    <label class="label" for="">Telefono</label>
                    <input class="input is-rounded" type="text" id="telefono" name="telefono" value="<?php echo $_SESSION['telefono'] ?>">
                    </div>
                </div>
                <div class="con4">
                <div class="g-recaptcha" data-sitekey="6LelmxwpAAAAAFS3KlCNxJf9TfDpe70SP2y0Ie3w"></div>
                </div>
                <div class="boton">
                    <input type="submit" class="button is-black" value="Actualizar" onclick="updatesuer()">
                </div> 
            </form>
        </div>

        

    </div>
    <script>
         function updatesuer(){
    let recaptchaResponse = grecaptcha.getResponse();
    if (!recaptchaResponse){
        message("Por favor, complete el reCAPTCHA", "is-danger");
        event.preventDefault();
        return false;
    }
    let id = <?php echo $_SESSION['identificacion']; ?>;
    let nombre1 = document.getElementById("nombre1").value;
    let nombre2 = document.getElementById("nombre2").value;
    let apellido1 = document.getElementById("apellido1").value;
    let apellido2 = document.getElementById("apellido2").value;
    let telefono = document.getElementById("telefono").value;
    let email = document.getElementById("email").value;

    const jsonData = {
        "identificacion": id,
        "primerNombre": nombre1,
        "segundoNombre": nombre2,
        "primerApellido": apellido1,
        "segundoApellido": apellido2,
        "telefono": telefono,
        "email": email
        }
    fetch('http://localhost/mymbarekove.shop/mymba/mymba/controller/users.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            message("Actualizado","is-primary");
        })
        .catch(error =>{
            console.error('Error:', error)
            message("Error","is-danger");
        });
    }


    function message(m, e) {
    let bot = document.querySelector(".boton");

    let mensajeAnterior = document.getElementById("message");
    if (mensajeAnterior) {
        mensajeAnterior.remove();
    }

    let div = document.createElement("div");
    div.className = `message ${e}`;
    div.id = "message";
    div.innerHTML = `
        <p>${m}</p>
    `;
    bot.appendChild(div);
}

</script>
</body>


</html>