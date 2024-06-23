<?php
require '../../config.php';
session_start();

// Verificar si se recibieron los parámetros esperados
    // Almacenar datos del pago en una variable
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

    // Verificar si el carrito está guardado en la sesión y es un array válido
    if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
        // Datos de envío
        $direcciontotal = $_SESSION['direccion'];
        $ciudad = $_SESSION['ciudad'];
        $detallesproducto = $_SESSION['carrito'];
        $id_usuario = $_SESSION['id_usuario'];

        // Calcular el total del pedido
        $sumaTotal = 0;
        foreach ($detallesproducto as $producto) {
            $sumaTotal += $producto['precio'] * $producto['cantidad'];
        }

        // Realizar una solicitud HTTP para enviar los detalles del pedido al servidor
        $datos_pedido = array(
            'usuario' => $id_usuario,
            'datospago' => $datospago,
            'ciudad' => $ciudad,
            'direccion' => $direcciontotal,
            'detalles' => $detallesproducto,
            'totalp' => $sumaTotal
        );

        $url_pedido = URL3 . '/controller/pedido.php';

        // Realizar la solicitud HTTP utilizando cURL
        $ch = curl_init($url_pedido);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos_pedido));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Manejar la respuesta
        if ($httpcode == 200) {
            // Éxito en la solicitud HTTP
            $response_data = json_decode($response, true);
            if ($response_data['exito']) {
                // Éxito en el pedido
                echo '<script>alert("PEDIDO EXITOSO: ' . $response_data['mensaje'] . '");</script>';
                // Limpiar el carrito de compras
                unset($_SESSION['carrito']);
                echo '<script>window.location.href = "' . URL3 . '/catalogo/pedido/verpedidos.php";</script>';
            } else {
                // Error en el pedido
                echo '<script>alert("ERROR EN EL PEDIDO: ' . $response_data['mensaje'] . '");</script>';
            }
        } else {
            // Error en la solicitud HTTP
            echo '<script>alert("ERROR: No se pudo conectar al servidor para enviar el pedido.");</script>';
        }
    } else {
        // Error: El carrito no está en la sesión o está vacío
        echo '<script>alert("ERROR: El carrito no está disponible.");</script>';
    }

?>
