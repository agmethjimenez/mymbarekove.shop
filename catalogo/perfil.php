<?php
require '../models/Http.php';
require '../config.php';
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();
require_once("../database/conexion.php");
require_once("../models/Usuarios.php");

$database = new Database();
$conexion = $database->connect();
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
    session_start();
    $usuario = new Usuario();

    $id = $_SESSION['id_usuario'];
    $usuario->verDatos($conexion, $id);
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
                        <input class="input is-rounded" type="text" id="nombre2" name="nombre2" value="<?php echo $_SESSION['nombre2']; ?>">
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
                    <input type="submit" class="button is-black" name="submit" value="Actualizar">
                </div>
                <?php
                if (isset($_POST['submit'])) {
                    $curl = curl_init();

                    $data = array(
                        "identificacion" => $_SESSION['identificacion'],
                        "primerNombre" => $_POST['nombre1'],
                        "segundoNombre" => $_POST['nombre2'],
                        "primerApellido" => $_POST['apellido1'],
                        "segundoApellido" => $_POST['apellido2'],
                        "telefono" => $_POST['telefono'],
                        "email" => $_POST['email']
                    );
                    $response = HttpRequest::put(URL.'/controller/users', $data,[
                        'token: ' . $_ENV['API_POST_USER'],
                        'Content-Type: application/json'
                    ]);
                    $responseData = json_decode($response, true);
                    if ($responseData['status']) {
                        echo '<div class="message is-primary" id="message">';
                        echo '<p>Datos Actualizados</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="message is-danger" id="message">';
                        echo '<p>Datos no actualizados</p>';
                        echo '</div>';
                    }
                }
                ?>
            </form>
        </div>
    </div>
</body>


</html>