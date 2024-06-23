<?php
session_start();
require '../config.php';
require '../models/Http.php';
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
    <link rel="icon" type="image/png" href="imgs/productos/Copia de Logo veterinaria animado azul rosado.png">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="./js/perfil.js"></script>
    <title>Perfil</title>
</head>

<body>
    <?php
    
    HttpClient::setUrl(URL . '/usuarios/' . $_SESSION['id_usuario']);
    $response = HttpClient::get();

    ?>
    <div class="wrapper">

        <div class="is-one-third" id="options">
            <ul>
                <li><a id="verinfo">Ver Información</a></li>
                <li><a href="cambiarclave.php" id="cambiarclave">Cambiar Clave</a></li>
                <li><a id="actualizar">Actualizar Información</a></li>
                <li><a href="./pedido/verpedidos.php">Ver pedidos</a></li>
                <li><a href="logout.php">Salir</a></li>
            </ul>
        </div>
        <div class="info" id="info">
            <h1 class="titulo">Perfil de Usuario</h1>
            <h1 class="tit"><strong>Identificacion</strong></h1>
            <p><?php echo $response['identificacion'] ?></p>
            <h1 class="tit"><strong>Nombres</strong></h1>
            <p><?php echo $response['primerNombre'] . ' ' . $response['segundoNombre'] ?></p>
            <h1 class="tit"><strong>Apellidos</strong></h1>
            <p><?php echo $response['primerApellido'] . ' ' . $response['segundoApellido'] ?></p>
            <h1 class="tit"><strong>Correo electronico</strong></h1>
            <p><?php echo $response['email'] ?></p>
            <h1 class="tit"><strong>Telefono</strong></h1>
            <p><?php echo $response['telefono'] ?></p>

        </div>

        <div class="actualizardatos" id="actualizardatos">
            <h1 class="titulo">Actualizar datos</h1>
            <p>*La identificacion y el tipo de identificacion no de pueden cambiar</p>
            <form method="post">
                <div class="con1">
                    <div>
                        <label class="label" for="">Primer Nombre</label>
                        <input class="input is-rounded" type="text" id="nombre1" name="nombre1" value="<?php echo $response['primerNombre']; ?>">
                    </div>
                    <div>
                        <label class="label" for="">Segundo Nombre</label>
                        <input class="input is-rounded" type="text" id="nombre2" name="nombre2" value="<?php echo $response['segundoNombre']; ?>">
                    </div>
                </div>
                <div class="con2">
                    <div>
                        <label class="label" for="">Primer apellido</label>
                        <input class="input is-rounded" type="text" id="apellido1" name="apellido1" value="<?php echo $response['primerApellido'] ?>">
                    </div>
                    <div>
                        <label class="label" for="">Segundo apellido</label>
                        <input class="input is-rounded" type="text" id="apellido2" name="apellido2" value="<?php echo $response['segundoNombre'] ?>">
                    </div>
                </div>
                <div class="con3">
                    <div>
                        <label class="label" for="">Correo</label>
                        <input class="input is-rounded" type="text" id="email" name="email" value="<?php echo $response['email'] ?>">
                    </div>
                    <div>

                        <label class="label" for="">Telefono</label>
                        <input class="input is-rounded" type="text" id="telefono" name="telefono" value="<?php echo $response['telefono'] ?>">
                    </div>
                </div>
                <div class="boton">
                    <input type="submit" class="button is-black" name="submit" value="Actualizar">
                </div>
                <?php
                if (isset($_POST['submit'])) {

                    $data = array(
                        "id" => $_SESSION['id_usuario'],
                        "nombre1" => $_POST['nombre1'],
                        "nombre2" => $_POST['nombre2'],
                        "apellido1" => $_POST['apellido1'],
                        "apellido2" => $_POST['apellido2'],
                        "telefono" => $_POST['telefono'],
                        "email" => $_POST['email']
                    );

                    HttpClient::setUrl(URL.'/usuarios/update');
                    HttpClient::setBody($data);
                    $responseData = HttpClient::put();

                    if (isset($responseData['status']) && $responseData['status']) {
                        echo '<div class="message is-primary" id="message">';
                        echo '<p>' . $responseData['mensaje'] . '</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="message is-danger" id="message">';
                        echo '<p>' . $responseData['mensaje'] . '</p>';
                        echo '</div>';
                    }
                }
                ?>
            </form>
        </div>
    </div>
</body>


</html>