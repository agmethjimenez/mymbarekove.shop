<?php
require '../config.php';
$payment = $_GET['payment_id'];
$status = $_GET['status'];
$payment_type = $_GET['payment_type'];
$order_id = $_GET['merchant_order_id'];

echo '<h3>Pago exitoso</h3>';
echo $payment, '<br>';
echo $status, '<br>';
echo $payment_type, '<br>';
echo $order_id, '<br>';
session_start();
$datospago = array(
    'payment_id' => $payment,
    'status' => $status,
    'payment_type' => $payment_type,
    'order_id' => $order_id
);

$direcciontotal = $_SESSION['direccion'];
$ciudad = $_SESSION['ciudad'];
$detallesproducto = $_SESSION['carrito'];
echo $ciudad;
echo $direcciontotal;
echo $_SESSION['id_usuario'];

$sumaTotal = 0;
foreach ($detallesproducto as $producto) {
    $sumaTotal += $producto['precio'] * $producto['cantidad'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script>
  function EnviarDatosenvio() {
    let datos = {
      usuario: <?php echo $_SESSION['id_usuario']?>,
      datospago: <?php echo json_encode($datospago); ?>,
      ciudad: "<?php echo isset($_SESSION['ciudad']) ? $_SESSION['ciudad'] : ''; ?>",
      direccion: "<?php echo isset($_SESSION['direccion']) ? $_SESSION['direccion'] : '';?>",
      detalles: <?php echo isset($_SESSION['carrito']) ? json_encode($_SESSION['carrito']) : '[]'; ?>,
      totalp: <?php echo $sumaTotal; ?>
    };
    fetch(`http://<?php echo URL ?>/controller/pedido.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(datos),
    })
      .then(response => response.json())
      .then(data => {
        if (data.exito) {
          alert('PEDIDO EXITOSO: ' + data.mensaje);
          <?php
          unset($_SESSION['carrito']);
          ?>
          localStorage.removeItem("carritoProductos");
          window.location.href = `http://<?php echo URL ?>/catalogo/pedido/verpedidos.php`;
        } else {
          alert('ERROR EN EL PEDIDO: ' + data.mensaje);
        }
      })
      .catch(error => {
        console.error('Error en la solicitud fetch:', error);
      });
    return false;
}

EnviarDatosenvio();
</script>
</body>
</html>