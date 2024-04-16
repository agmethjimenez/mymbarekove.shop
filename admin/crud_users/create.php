<? require '../../config.php'; 
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();
session_start();
if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['email'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit; 
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
    <link rel="stylesheet" href="./estilos/update.css">
    <title>Document</title>
</head>
<body>
<div class="contenedor">
    <form action="create.php" method="post">
    <?php
?>
    <div class="title" ><h1>Agregar Usuario</h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">Tipo ID</label>
        <div class="select is-primary" id= "select" name="tipoid">
            <select name="tipoid" id="tipoid" required>
                <option value="0">Seleccione un tipo de id</option>
                <option value="1">Cedula de Ciudadania</option>
                <option value="2">Cedula de Extranjeria</option>
                <option value="3">Pasaporte</option>
                <option value="4">Permiso Especial de Permanencia</option>
            </select>
        </div>
        </div>
        <div class="con1-2">
        <label for="" class="label">Identificacion</label>
        <input class="input is-primary" type="text"  name="identificacion" required>
        </div>   
    </div>


        <div class="con2">
            <div class="con2-1">
        <label for="" class="label">Primer nombre</label>
        <input class="input is-primary" type="text" name="nombre1" required>
        </div>
        <div class="con2-2">
        <label for="" class="label">Segundo nombre</label>
        <input class="input is-primary" type="text" name="nombre2" required>
        </div>
        </div>
        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Primer apellido</label>
        <input class="input is-primary" type="text" name="apellido1" required>
        </div>
        <div class="con3-2">
        <label for="" class="label">Segundo apellido</label>
        <input class="input is-primary" type="text" name="apellido2" required>
        </div>    
    </div>
        <div class="con4">
            <div class="con4-1">
            <label for="" class="label">Email</label>
        <input class="input is-primary" type="email" name="email" required>
        </div>
        <div class="con4-2">
        <label for="" class="label">Telefono</label>
        <input class="input is-primary" type="text"  name="telefono" required>
        </div>    
    </div>
        <div class="con5">
            <div class="con5-1">
        <label for="" class="label">Contraseña</label>
        <input class="input is-primary" name="password" type="password" required>
        </div>   
    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Agregar</button>
    </div>
    

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = $_POST['identificacion'];
    $cod_id = $_POST['tipoid'];
    $primernombre = $_POST['nombre1'];
    $segundonombre = $_POST['nombre2'];
    $primerapellido = $_POST['apellido1'];
    $segundoapellido = $_POST['apellido2'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['password'];

    $hashed = password_hash($contraseña, PASSWORD_BCRYPT);

    $data = array(
        "identificacion" => $id_usuario,
        "tipoid" => $cod_id,
        "nombre1" => $primernombre,
        "nombre2" => $segundonombre,
        "apellido1" => $primerapellido,
        "apellido2" => $segundoapellido,
        "email" => $email,
        "telefono" => $telefono,
        "password" => $hashed
    );

    $payload = json_encode($data);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.$_ENV['URL'].'/controller/users',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'token: '.API_POST_USER
        ),
    ));

    $response = curl_exec($curl);
    $responsecode = json_decode($response, true);

    if ($responsecode && $responsecode['exito']) {
        echo '<div class="notification is-success">';
        echo '<button class="delete"></button>';
        echo '¡Usuario insertado correctamente!';
        echo '<a href="./crud.php">Volver</a>';
        echo '</div>';
    } else {
        echo '<div class="notification is-danger">';
        echo '<button class="delete"></button>';
        echo '¡Error! ' . ($responsecode['mensaje'] ?? 'No se pudo completar la solicitud');
        echo '</div>';
    }

    curl_close($curl);
}
?>
    </div>
    </form>
    </body>
</html>