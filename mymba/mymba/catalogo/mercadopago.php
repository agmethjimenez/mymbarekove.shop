<?php 
require './vendor/autoload.php';

MercadoPago\SDK::setAccessToken('TEST-5218474367584835-120418-c149fcd65c1a1a0e0f2b0577e2e9de4a-1556051552');

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="checkout-btn"></div>
</body>
// SDK MercadoPago.js
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('TEST-4b5231e8-53ce-4ed1-b049-3ae3b78ddbcd',{
        locale:"es-COL"
    });

    mp.checkout({
        preferences: 
    })
</script>
</html>