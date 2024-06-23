<?php
include '../../models/Http.php';
include '../../config.php';

if(isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['email']) && isset($_POST['token'])){
    $pass1  = $_POST['password1'];
    $pass2 = $_POST['password2'];
    $email = $_POST['email'];
    $token = $_POST['token'];

    if ($pass1 != $pass2) {
        echo '<div class="message is-danger" id="message">';
        echo '<p>Usuario no encontrado</p>';
        echo '</div>';
    }
    HttpClient::setUrl(URL.'/clave/corregir');
    HttpClient::setBody([
        'email'=>$email,
        'token'=>$token,
        'password'=>$pass1
    ]);
    $cambio = HttpClient::post();

    if($cambio['status']){
        echo '<div class="message is-primary" id="message">';
        echo '<p>'.$cambio['mensaje'].'</p>';
        echo '<a href="../login.php" class="button is-primary">Iniciar Sesion</a>';
        echo '</div>';
    }else{
        echo '<div class="message is-danger" id="message">';
        echo '<p>'.$cambio['mensaje'].'</p>';
        echo '<a href="../login.php" class="button is-primary">Iniciar Sesion</a>';
        echo '</div>';
    }
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="../css/login.css">
    <title>Recuperar contraseña</title>

</head>