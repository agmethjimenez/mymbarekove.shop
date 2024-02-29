<?php
session_start();
require '../vendor/autoload.php';
MercadoPago\SDK::setAccessToken('TEST-5218474367584835-120418-c149fcd65c1a1a0e0f2b0577e2e9de4a-1556051552');

if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];

    $preference = new MercadoPago\Preference();
    $items = array();

    foreach ($carrito as $producto) {
        $id_producto = $producto['id'];
        $nombre = $producto['nombre'];
        $cantidad = $producto['cantidad'];
        $precio = $producto['precio'];

        $item = new MercadoPago\Item();
        $item->id = $id_producto;
        $item->title = $nombre;
        $item->quantity = $cantidad;
        $item->unit_price = $precio;
        $item->currency_id = 'COP';

        $items[] = $item;
    }

    $preference->items = $items;

    $preference->back_urls = array(
        "success" => "http://localhost/mymbarekove.shop/catalogo/success.php",
        "failure" => "http://localhost/mymbarekove.shop/catalogo/fail.php"
    );

    $preference->auto_return = "approved";
    $preference->binary_mode = true;

    $preference->save();
} else {
    echo 'No hay productos';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="imgs/productos/Copia de Logo veterinaria animado azul rosado.png">

    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        
    </style>
</head>
<body>
<div class="container">
    <?php
    $total = 0;
    foreach ($carrito as $producto) {
        echo "- " . $producto['nombre'] . " (" . $producto['cantidad'] . " unidades) - Precio: $" . $producto['precio'] . "<br>";
        $total += $producto['total'];     
    }
    echo 'Total: $'.$total.'';
    ?>
    <div class="checkout-btn" onclick="EnviarDatosenvio()"></div>
</div>

<script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('TEST-4b5231e8-53ce-4ed1-b049-3ae3b78ddbcd', {
        locale: 'es_CO'
    });
    mp.checkout({
        preference: {
            id: '<?php echo $preference->id ?>'
        },
        render: {
            container: '.checkout-btn',
            type: 'wallet',
            label: 'Pagar Pedido'
        }
    })
</script>
</body>
</html>
