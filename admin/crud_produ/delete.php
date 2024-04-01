<?php
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); // Corregido el directorio donde se encuentra el archivo .env
$dotenv->load();

require_once("../../database/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];

    // Realizar la solicitud cURL para eliminar el producto en la otra aplicación
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
            'Authorization: Bearer '.$_ENV['dku'].''
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    // Verificar la respuesta de la solicitud cURL
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
