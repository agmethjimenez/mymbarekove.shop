<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("location: login.php"); 
}
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
            box-sizing: border-box;
        }

        body {
            font-family: 'Oxygen', sans-serif;
            background-color: #f2e4bb;
            margin: 0;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .titulo {
            font-weight: bold;
            font-size: 34px;
            text-align: center;
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

        .cambiarclaved form {
            padding: 30px;
            border: black solid 1px;
            background-color: white;
            border-radius: 20px;
            display: flex;
            flex-wrap: wrap;
            width: 50%;
            gap: 20px;
            flex-direction: column;
            justify-content: center;
            margin: auto;
        }

        .cambiarclaved form .con1 {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .cambiarclaved form .con2 {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .con3 {
            display: flex;
            justify-content: center;
        }

        input[type="password"] {
            width: 257px;
            max-width: 300px;
        }

        #message {
            padding: 20px;
        }

        .g-recaptcha {
            display: flex;
            justify-content: center;
            /* Ajusta el origen de la transformación para mantener la posición */
        }

        .boton2 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .boton2 input {
            width: 200px;
        }

        /* Ajustes para pantallas más pequeñas */
        @media screen and (max-width: 768px) {
            .wrapper {
                overflow-y: auto;
                display: flex;
                align-items: flex-start;
            }

            .titulo {
                font-weight: bold;
                font-size: 28px;
                text-align: center;
            }

            .cambiarclaved {
                width: auto;
            }

            .cambiarclaved form {
                width: 90%;
                display: flex;
                flex-direction: column;
                gap: 10px;
                flex-wrap: wrap;
                width: auto;
            }

            input[type="password"] {
                max-width: none;
                /* Elimina el ancho máximo en pantallas más pequeñas */
                width: 220px;
            }

            .g-recaptcha {
                transform: scale(0.80);
                /* Reduzca el tamaño del reCAPTCHA en pantallas más pequeñas según sea necesario */
                /*transform-origin: 0 0; /* Ajusta el origen de la transformación para mantener la posición */
                display: flex;
                justify-content: center;
            }

            #message {
                padding: 20px;
                font-size: 13px;
            }
        }
    </style>
    <title>Actualizar Contraseña</title>
</head>

<body>
    <div class="wrapper">
        <div class="cambiarclaved" id="cambiarclaved">
            <form method="post" action="">
                <h1 class="titulo">Cambio de contraseña</h1>
                <div class="con1">
                    <div>
                        <label class="label" for="">Contraseña actual</label>

                        <input class="input is-rounded" type="password" placeholder="Ingrese su clave actual" name="passwordactual" id="passwordactual" required>
                    </div>
                </div>
                <div class="con2">
                    <div>
                        <label class="label" for="">Contraseña nueva</label>
                        <input class="input is-rounded" name="passwordnueva" type="password" placeholder="Ingrese su clave nueva" id="passwordnueva">
                    </div>
                    <div>
                        <label class="label" for="">Contraseña nueva</label>
                        <input class="input is-rounded" type="password" name="passwordnueva2" placeholder="Ingrese su clave nueva otra vez" id="passwordnueva2">
                    </div>
                </div>
                <div class="con3">
                    <div class="g-recaptcha" data-sitekey="6LelmxwpAAAAAFS3KlCNxJf9TfDpe70SP2y0Ie3w"></div>

                </div>
                <div class="boton2">
                    <input type="submit" name="submit" class="button is-black" value="Actualizar" onclick="cambioClave(event)">
                </div>
                <?php
                /*if (isset($_POST['submit'])) {
                    $id = $_SESSION['id_usuario'];
                    $claveactual = $_POST["passwordactual"];
                    $clavenueva = $_POST["passwordnueva"];
                    $clavenueva2 = $_POST["passwordnueva2"];
                
                    if (empty($id) || empty($claveactual) || empty($clavenueva) || empty($clavenueva2)) {
                        echo '<div class="notification is-danger">Por favor, complete todos los campos</div>';
                        exit();
                    }
                
                    if ($claveactual == $clavenueva) {
                        echo '<div class="notification is-danger">La contraseña actual es igual a la nueva, cambíela</div>';
                        exit();
                    }
                
                    if ($clavenueva != $clavenueva2) {
                        echo '<div class="notification is-danger">Las contraseñas nuevas deben ser iguales</div>';
                        exit();
                    }
                
                    // Preparar datos para la solicitud al API
                    $jsonData = json_encode(array(
                        "identificacion" => $id,
                        "claveactual" => $claveactual,
                        "clavenueva" => $clavenueva,
                        "clavenueva2" => $clavenueva2
                    ));
                
                    // Realizar la solicitud al API utilizando cURL
                    $api_url = 'http://localhost/mymbarekove.shop/controller/password.php';
                
                    $ch = curl_init($api_url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $_ENV['PASSWORD_TOKEN']
                    ));
                
                    // Realizar la solicitud y obtener la respuesta
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $response = json_decode($response, true);
                
                    // Procesar la respuesta del API y mostrar las alertas de Bulma CSS
                    if ($response['exito']) {
                        echo '<script> window.location.href = "logout.php"</script>';
                    } else {
                        echo '<div class="notification is-danger">' . $response['mensaje'] . '</div>';
                        exit();
                    }
                }*/
                ?>
            </form>
        </div>
    </div>
    <script>
        function cambioClave(event) {
            event.preventDefault(); // Evita que el formulario se envíe de forma tradicional

            let recaptchaResponse = grecaptcha.getResponse();

            if (!recaptchaResponse) {
                mesage("Por favor, complete el reCAPTCHA", "is-danger");
                return;
            }

            let id = <?php echo $_SESSION['id_usuario']; ?>;
            let claveactual = document.getElementById("passwordactual").value;
            let clavenueva = document.getElementById("passwordnueva").value;
            let clavenueva2 = document.getElementById("passwordnueva2").value;

            // Validar que los campos no estén vacíos
            if (!id || !claveactual || !clavenueva || !clavenueva2) {
                mesage("Por favor, complete todos los campos", "is-danger");
                return;
            }
            if (claveactual == clavenueva) {
                mesage("Contraseña actual es igual a la nueva, cambiela", "is-danger");
                return;
            }
            if (clavenueva != clavenueva2) {
                mesage("La contraseñas nuevas deben ser iguales", "is-danger");
                return;
            }
        }

    const jsonData = {
        "id": id,
        "claveactual": claveactual,
        "clavenueva": clavenueva,
        "clavenueva2": clavenueva2, 
    };

    fetch('http://127.0.0.1:8000/api/credencial/cambioclave', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',            
        },
        body: JSON.stringify(jsonData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            alert(data.mensaje);
            mesage(data.mensaje, "is-primary");
            window.location.href = "logout.php";
        } else {
            alert(data.mensaje);
            mesage(data.mensaje, "is-danger");
        }
    });
    </script>
</body>

</html>