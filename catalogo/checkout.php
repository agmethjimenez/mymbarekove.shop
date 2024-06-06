<?php
require '../config.php';
session_start();
require '../vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

function authenticate()
{
    // Obteniendo el token de acceso desde una fuente segura (en este caso, directo en el código)
    $mpAccessToken = 'TEST-6693173666765877-031700-87d1da02f11f43d3229da9902972b0ca-1732113818';

    // Configurando el token en el SDK de MercadoPago
    MercadoPagoConfig::setAccessToken($mpAccessToken);

    // Opcional: Configurar el entorno de ejecución a LOCAL para pruebas en localhost
    MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
}

// Autenticar la aplicación
authenticate();

if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];

    function createPreferenceRequest($items, $payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];

        $backUrls = [
            "success" => URL . '/catalogo/success.php',
            "failure" => URL . '/catalogo/fail.php'
        ];

        $request = [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "NAME_DISPLAYED_IN_USER_BILLING",
            "external_reference" => "1234567890",
            "expires" => false,
            "auto_return" => 'approved'
        ];

        return $request;
    }

    function createPaymentPreference()
    {
        $carrito = $_SESSION['carrito'];
        $items = [];

        foreach ($carrito as $producto) {
            $items[] = [
                "id" => $producto['id'],
                "title" => $producto['nombre'],
                "description" => "Product Description",
                "currency_id" => 'COP',
                "quantity" => $producto['cantidad'],
                "unit_price" => $producto['precio']
            ];
        }

        // Obtener información del usuario
        $user = $_SESSION['id_usuario'];
        $payer = [
            "name" => "Juan",
            "surname" => "carlos",
            "email" => "carlos@gmail.com",
        ];

        $request = createPreferenceRequest($items, $payer);
        $client = new PreferenceClient();

        try {
            $preference = $client->create($request);
            return $preference;
        } catch (MPApiException $error) {
            return null;
        }
    }

    // Crear la preferencia de pago
    $preference = createPaymentPreference();

    if ($preference) {
        $init_point = $preference->sandbox_init_point;
    } else {
        echo 'Error al crear la preferencia de pago';
    }
} else {
    echo 'No hay productos';
    header("Location: pagina_de_pago.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="imgs/productos/Copia de Logo veterinaria animado azul rosado.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <title>Checkout</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oxygen&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-family: 'Oxygen', sans-serif;

        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="tittle">Compra</h1>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($carrito as $producto) :
                    $total += $producto['total'];
                ?>

                    <tr>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td>$<?php echo number_format($producto['precio']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><em>Es importante que después de que el pago se acredite correctamente, dar clic en "Volver al sitio" para que los detalles de la compra se guarden correctamente.</em></p>
        <p>Total: $<?php echo number_format($total); ?></p>
        <div class="checkout-btn" onclick="EnviarDatosenvio()"></div>
        <a href="<?php echo $init_point ?>" class="button is-link">Pagar</a>
    </div>
</body>
<script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>

</html>
