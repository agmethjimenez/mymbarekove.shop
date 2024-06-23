<?php
session_start();
include '../../config.php';
include '../../models/Http.php';
if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
   
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];

    HttpClient::setUrl(URL.'/productos/delete/'.$id.'/'.$token);
    $response = HttpClient::delete();

    
    if ($response['status']) {
        header("location: productos.php?success=true");
        exit;
    } else {
        header("location: productos.php?success=false");
        exit;
    }
}
?>
