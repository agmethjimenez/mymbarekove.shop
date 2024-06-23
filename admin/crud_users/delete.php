<?php
session_start();
require '../../config.php';
require '../../models/Http.php';

if(isset($_SESSION['id_admin'], $_SESSION['username'],$_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit; 
}
if($_SERVER["REQUEST_METHOD"] === "GET"){
    $id = $_GET['id'];
    HttpClient::setUrl(URL.'/api/usuarios/'.$id.'/'.$SESSION['token']);
    $responsee = HttpClient::delete();
    
    if ($responsee['status']) {
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