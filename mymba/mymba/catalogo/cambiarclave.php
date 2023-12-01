<?php
require_once("../database/conexion.php");
require_once("../models/Usuarios.php");
require_once("../controller/password.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oxygen&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');

        * {
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .titulo {
            font-weight: bold;
            font-size: 34px;
        }

        .cambiarclaved {
            width: 100%;
            flex-grow: 2;
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 5%;
            justify-content: center;
            align-items: center;
        }

        .con1,
        .con2,
        .con3,
        .con4 {
            display: flex;
        }

        .cambiarclaved form {
            padding: 30px;
            border: black solid 1px;
            background-color: white;
            border-radius: 20px;
            display: flex;
            flex-wrap: wrap;
            width: 60%;
            gap: 50px;
            flex-direction: column;

            justify-content: center;
        }

        .cambiarclaved form .con1,
        .con2 {
            display: flex;
            gap: 20px;
        }

        input[type="password"] {
            width: 350px;
        }

        #message {
            padding: 20px;
        }

        body {
            font-family: 'Oxygen', sans-serif;
            background-color: #f2e4bb;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    $usuario = new Usuario();

    $id = $_SESSION['id_usuario'];
    $usuario->verDatos($id);
    ?>
    <div class="wrapper">
        <div class="cambiarclaved" id="cambiarclaved">
            <form method="post">
                <h1 class="titulo">Cambio de contraseña</h1>
                <div class="con1">
                    <div>
                        <label class="label" for="">Contraseña actual</label>

                        <input class="input is-rounded" type="password" placeholder="Ingrese su clave actual" id="passwordactual" required>
                    </div>
                </div>
                <div class="con2">
                    <div>
                        <label class="label" for="">Contraseña nueva</label>
                        <input class="input is-rounded" type="password" placeholder="Ingrese su clave nueva" id="passwordnueva">
                    </div>
                    <div>
                        <label class="label" for="">Contraseña nueva</label>
                        <input class="input is-rounded" type="password" placeholder="Ingrese su clave nueva otra vez" id="passwordnueva2">
                    </div>
                </div>
                <div class="con3">
                    <div class="g-recaptcha" data-sitekey="6LelmxwpAAAAAFS3KlCNxJf9TfDpe70SP2y0Ie3w"></div>

                </div>
                <div class="boton2">
                    <input type="submit" class="button is-black" value="Actualizar" onclick="cambioClave(event)">
                </div>
            </form>
        </div>
    </div>
    <script>
        function cambioClave(event) {
    let recaptchaResponse = grecaptcha.getResponse();

    if (!recaptchaResponse) {
        mesage("Por favor, complete el reCAPTCHA", "is-danger");
        event.preventDefault();
        return false;
    }

    let id = <?php echo $_SESSION['identificacion']; ?>;
    let claveactual = document.getElementById("passwordactual").value;
    let clavenueva = document.getElementById("passwordnueva").value;
    let clavenueva2 = document.getElementById("passwordnueva2").value;

    const jsonData = {
        "identificacion": id,
        "claveactual": claveactual,
        "clavenueva": clavenueva,
        "clavenuevados": clavenueva2,
    }

    fetch('http://localhost/mymbarekove.shop/mymba/mymba/controller/password.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Error al actualizar contraseña');
        }
    })
    .then(data => {
        console.log(data);
        alert("Contraseña actualizada exitosamente");
        mesage("!Contraseña actualizada!", "is-primary");

        // Redirige a login.php después de actualizar la contraseña
        window.location.href = "login.php";

        event.preventDefault();
        return false;
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Error al actualizar");
        mesage("!Error al actualizar contraseña", "is-danger");
        event.preventDefault();
        return false;
    });
}

function mesage(m, e) {
    let bot = document.querySelector(".boton2");

    let mensajeAnterior = document.getElementById("message");
    if (mensajeAnterior) {
        mensajeAnterior.remove();
    }

    let div = document.createElement("div");
    div.className = `message ${e}`;
    div.id = "message";
    div.innerHTML = `<p>${m}</p>`;
    bot.appendChild(div);
}

        
    </script>
</body>

</html>