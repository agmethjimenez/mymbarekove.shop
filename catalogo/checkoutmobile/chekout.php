<?php
require '../../config.php';
session_start();
require '../../vendor/autoload.php';

use MercadoPago\Item;
use MercadoPago\Preference;

// Configurar el token de acceso de MercadoPago
MercadoPago\SDK::setAccessToken("TEST-6693173666765877-031700-87d1da02f11f43d3229da9902972b0ca-1732113818");

// Obtener el cuerpo de la solicitud y decodificar los datos JSON
$body = file_get_contents('php://input');
$data = json_decode($body, true);

// Iniciar sesión si no está iniciada

// Verificar si los datos esperados están presentes en el cuerpo de la solicitud
if (isset($data['idUsuario'], $data['carrito'], $data['direccion'], $data['ciudad'])) {
    // Almacenar los datos en la sesión
    $_SESSION['carrito'] = $data['carrito'];
    $_SESSION['id_usuario'] = $data['idUsuario'];
    $_SESSION['direccion'] = $data['direccion'];
    $_SESSION['ciudad'] = $data['ciudad'];

    // Obtener los datos de la sesión
    $idUsuario = $_SESSION['id_usuario'];
    $carrito = $_SESSION['carrito'];
    $direccion = $_SESSION['direccion'];
    $ciudad = $_SESSION['ciudad'];

    // Verificar que $carrito sea un array antes de intentar iterar sobre él
    if (is_array($carrito)) {
        // Crear la preferencia de MercadoPago
        $preference = new Preference();
        $items = array();

        foreach ($carrito as $producto) {
            $item = new Item();
            $item->id = $producto['id'];
            $item->title = $producto['nombre'];
            $item->quantity = $producto['cantidad'];
            $item->unit_price = $producto['precio'];
            $item->currency_id = 'COP';
            $items[] = $item;
        }

        $preference->items = $items;
        $preference->payment_methods = array(
            "excluded_payment_types" => array(
                array("id" => "ticket"),
                array("id" => "bank_transfer") 
            )
        );
        $preference->back_urls = array(
            "success" => 'https://463e-2800-486-81a-1f00-d41b-cede-7eab-85c5.ngrok-free.app/mymbarekove.shop/catalogo/checkoutmobile/success.php',
            "failure" => 'https://463e-2800-486-81a-1f00-d41b-cede-7eab-85c5.ngrok-free.app/mymbarekove.shop/catalogo/fail.php',
        );
        $preference->auto_return = "approved";
        $preference->binary_mode = true;

        // Guardar la preferencia
        $preference->save();

        // Respuesta con la URL de la preferencia de MercadoPago
        $respuesta = array('exito' => true, 'mensaje' => 'Preferencia de MercadoPago creada correctamente', 'url' => $preference->sandbox_init_point);
        echo json_encode($respuesta);
    } else {
        // Si $carrito no es un array, envía una respuesta de error
        $respuesta = array('exito' => false, 'mensaje' => 'El carrito no es un array');
        echo json_encode($respuesta);
    }
} else {
    // Respuesta de error: datos faltantes
    $respuesta = array('exito' => false, 'mensaje' => 'Faltan datos en la solicitud');
    echo json_encode($respuesta);
}
?>