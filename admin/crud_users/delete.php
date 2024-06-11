<?php
require '../../config.php';
require '../../models/Http.php';
require '../../database/conexion.php';
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
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
if($_SERVER["REQUEST_METHOD"] === "GET"){
    $id = $_GET['id'];
    $response = HttpRequest::delete(URL.'/controller/users/'.$id,['token: Bearer '.$_ENV['dku'].'']);
    
    $responsee = json_decode($response, true); 

    if ($responsee && $responsee['status']) {
        header("Location: crud.php?success=true");
    } else {
        header("Location: crud.php");
    }
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
    <title>DELETE</title>
</head>
<body>
</body>
</html>