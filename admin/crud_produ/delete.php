<?php
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

require_once("../../database/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/mymbarekove.shop/controller/producto/' . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'token: Bearer '.$_ENV['dku'].''
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $responseData = json_decode($response, true);
    if (isset($responseData['status']) && $responseData['status']) {
        header("location: productos.php?success=true");
        exit;
    } else {
        header("location: productos.php?success=false");
        exit;
    }
}
?>
