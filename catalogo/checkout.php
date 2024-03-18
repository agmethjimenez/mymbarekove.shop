<?php
session_start();
require '../vendor/autoload.php';
//este es el de la cuenbta
//MercadoPago\SDK::setAccessToken('TEST-5218474367584835-120418-c149fcd65c1a1a0e0f2b0577e2e9de4a-1556051552');

//este de prueba
MercadoPago\SDK::setAccessToken("TEST-6693173666765877-031700-87d1da02f11f43d3229da9902972b0ca-1732113818");
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

    $preference->payment_methods = array(
        "excluded_payment_types" => array(
            array("id" => "ticket"),
            array("id" => "bank_transfer") 
        )
    );

    $preference->back_urls = array(
        "success" => "http://localhost/mymbarekove.shop/catalogo/success.php",
        "failure" => "http://localhost/mymbarekove.shop/catalogo/fail.php"
    );

    $preference->auto_return = "approved";
    $preference->binary_mode = true;

    $preference->save();
} else {
    echo 'No hay productos';
    header("location: pagina_de_pago.php");
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
            foreach ($carrito as $producto): 
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
</div>
</body>
<script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    //const mp = new MercadoPago('TEST-4b5231e8-53ce-4ed1-b049-3ae3b78ddbcd'
    const mp = new MercadoPago('TEST-2936afc4-a352-4909-92eb-b6ea44508d3b', {
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
</html>
