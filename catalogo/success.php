<?php
session_start();
require '../config.php';
require '../models/Http.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>¡¡Success!!</title>
</head>
<body>
</body>
</html>
<?php
// Obtener datos de la URL
$payment = $_GET['payment_id'];
$status = $_GET['status'];
$payment_type = $_GET['payment_type'];
$order_id = $_GET['merchant_order_id'];



// Datos del pago
$datospago = array(
    'payment_id' => $payment,
    'status' => $status,
    'payment_type' => $payment_type,
    'order_id' => $order_id
);

// Obtener datos de la sesión
$direccion = $_SESSION['direccion'];
$ciudad = $_SESSION['ciudad'];
$detallesproducto = $_SESSION['carrito'];

// Calcular el total
$sumaTotal = 0;
foreach ($detallesproducto as $producto) {
    $sumaTotal += $producto['precio'] * $producto['cantidad'];
}
$data = array(
    'usuario' => $_SESSION['id_usuario'],
    'datospago' => $datospago,
    'ciudad' => $ciudad,
    'direccion' => $direccion,
    'detalles' => $_SESSION['carrito'],
    'totalp' => $sumaTotal
);
// Configurar la solicitud HTTP
HttpClient::setUrl(URL . '/pedidos/create');
HttpClient::setBody($data);

// Enviar la solicitud HTTP
$insercion = HttpClient::post();

if ($insercion['status']) {
    // Eliminar el carrito de la sesión
    unset($_SESSION['carrito']);
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Éxito",
            text: "' . addslashes($insercion['mensaje']) . '"
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem("carritoProductos");
                window.location.href = "pedido/verpedidos.php";
            }
        });
    </script>';
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al insertar pedido'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './checkout.php';
            }
        });
    </script>";
}
?>

