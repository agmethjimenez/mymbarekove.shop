<?php
require '../../config.php';

// Obtener el ID del pedido de la URL
$pedidoID = $_GET['id'];

// URL de la API local
$url_api = URL.'/controller/pedido/'.$pedidoID.'';

// Inicializar cURL
$ch = curl_init();

// Configurar la solicitud cURL
curl_setopt($ch, CURLOPT_URL, $url_api);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Ejecutar la solicitud cURL y decodificar la respuesta JSON
$response = curl_exec($ch);

// Verificar si hay errores
if ($response === false) {
    echo 'Error en la solicitud cURL: ' . curl_error($ch);
    die();
}

// Decodificar la respuesta JSON
$pedido = json_decode($response, true);

// Verificar si se obtuvieron los datos correctamente
if ($pedido === null) {
    echo 'Error al decodificar la respuesta JSON';
    die();
}

// Calcular el subtotal
$subtotal = $pedido[0]['total'] / 1.19;

// Crear el PDF con TCPDF
require_once __DIR__ . '/../../vendor/autoload.php';

// Crear una instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Factura');
$pdf->SetSubject('Factura');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Establecer márgenes
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// Agregar una página
$pdf->AddPage();

// HTML contenido del PDF
$html = '
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <style>
    .title {
        color: #333;
        font-size: 24px;
    }
    table {
        width: 100%;
        font-size: 11px;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .table th, .table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }
    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    #idcolum {
        width: 1%;
    }
    #idcolum, .table th:first-child, .table td:first-child {
        width: 30px;
    }
    .footer {
        margin-top: 20px;
        font-size: 12px;
        color: #666;
    }
       
    </style>
</head>
<body>
<h1 class="title">Factura</h1>
<p><strong>No Pago: </strong>'. $pedido[0]['detalles_pago']['payment_id'] .'</p>
<p><strong>Identificación:</strong> ' . $pedido[0]['identificacion'] . '</p>
<p><strong>Nombre del Comprador:</strong> ' . $pedido[0]['nombreCompleto'] . '</p>
<p><strong>Fecha:</strong> ' . $pedido[0]['fecha'] . '</p>
<p><strong>Ciudad:</strong> ' . $pedido[0]['ciudad'] . '</p>
<p><strong>Tipo pago:</strong> ' . $pedido[0]['detalles_pago']['payment_type'] . '</p>
<p><strong>Dirección:</strong> ' . $pedido[0]['direccion'] . '</p>
<table class="table">
<thead>
    <tr>
        <th id="idcolum"><strong>ID</strong></th>
        <th><strong>Producto</strong></th>
        <th><strong>Cantidad</strong></th>
        <th><strong>Precio Unitario</strong></th>
        <th><strong>Total</strong></th>
    </tr>
</thead>
<tbody>';

foreach ($pedido[0]['details'] as $detalle) {
    // Agregar una fila para cada producto
    $html .= '<tr>';
    $html .= '<td id="idcolum">' . $detalle['idProducto'] . '</td>';
    $html .= '<td>' . $detalle['nombre'] . '</td>';
    $html .= '<td>' . $detalle['cantidad'] . '</td>';
    $html .= '<td>$' . number_format($detalle['total'] / $detalle['cantidad'], 2) . '</td>';
    $html .= '<td>$' . number_format($detalle['total'], 2) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>
</table>
<p><strong>Subtotal:</strong> $' . number_format($subtotal, 2) . '</p>
<p><strong>IVA (19%):</strong> $' . number_format($pedido[0]['total'] - $subtotal, 2) . '</p>
<p><strong>Total:</strong> $' . number_format($pedido[0]['total'], 2) . '</p>
</body>';

// Escribir HTML al documento PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y generar el PDF
$pdf->Output('factura.pdf', 'I');
?>