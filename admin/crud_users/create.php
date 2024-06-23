<?php 
session_start();
require '../../config.php'; 
require '../../models/Http.php';
if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Crear usuario</title>
</head>
<body>
<div class="contenedor">
    <form action="create.php" method="post">
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
        "tipoId" => $cod_id,
        "primerNombre" => $primernombre,
        "segundoNombre" => $segundonombre,
        "primerApellido" => $primerapellido,
        "segundoApellido" => $segundoapellido,
        "email" => $email,
        "telefono" => $telefono,
        "password" => $hashed
    );
    /*
    {
  "identificacion": 1027400956,
  "tipoId": 1,
  "primerNombre": "Agmeth",
  "segundoNombre": "Emilio",
  "primerApellido": "Jimenez",
  "segundoApellido": "Castro",
  "email": "agmeth.jimenez2005@gmail.com",
  "telefono":3124376338,
  "password": "agmeth123"
}
    */ 
    HttpClient::setUrl(URL.'/usuario');
    HttpClient::setBody($data);
    $responsecode = HttpClient::post();

    if ($responsecode['status']) {
        echo '<div class="notification is-success">';
        echo '<button class="delete"></button>';
        echo '¡Usuario insertado correctamente!';
        echo '</div>';
    } else {
        mostrarNotificacion($responsecode['mensaje'],"danger");
    }
}
?>
    </div>
    </form>
    </body>
</html>