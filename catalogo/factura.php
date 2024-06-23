<?php
session_start();
require '../models/Http.php';
require '../config.php';
$pedidoID = $_SESSION['num_pedido'];


HttpClient::setUrl(URL."/pedidos/".$pedidoID);
$pedido = HttpClient::get();

$subtotal = $pedido['total'] / 1.19;

require_once __DIR__ . '../../vendor/autoload.php';

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Factura');
$pdf->SetSubject('Factura');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

$pdf->AddPage();

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
<p><strong>No Pago: </strong>'. $pedido['detalles_pago']['payment_id'] .'</p>
<p><strong>Identificación:</strong> ' . $pedido['usuario']['identificacion'] . '</p>
<p><strong>Nombre del Comprador:</strong> ' . $pedido['usuario']['primerNombre'] .' '. $pedido['usuario']['segundoNombre'] .' '. $pedido['usuario']['primerApellido'] .' '. $pedido['usuario']['segundoApellido'] .' '.  '</p>
<p><strong>Fecha:</strong> ' . $pedido['fecha'] . '</p>
<p><strong>Ciudad:</strong> ' . $pedido['ciudad'] . '</p>
<p><strong>Tipo pago:</strong> ' . $pedido['detalles_pago']['payment_type'] . '</p>
<p><strong>Dirección:</strong> ' . $pedido['direccion'] . '</p>
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

foreach ($pedido['detallespedido'] as $detalle) {
    $html .= '<tr>';
    $html .= '<td id="idcolum">' . $detalle['idProducto'] . '</td>';
    $html .= '<td>' . $detalle['producto']['nombre'] . '</td>';
    $html .= '<td>' . $detalle['cantidad'] . '</td>';
    $html .= '<td>$' . number_format($detalle['total'] / $detalle['cantidad'], 2) . '</td>';
    $html .= '<td>$' . number_format($detalle['total'], 2) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>
</table>
<p><strong>Subtotal:</strong> $' . number_format($subtotal, 2) . '</p>
<p><strong>IVA (19%):</strong> $' . number_format($pedido['total'] - $subtotal, 2) . '</p>
<p><strong>Total:</strong> $' . number_format($pedido['total'], 2) . '</p>
</body>';

// Escribir HTML al documento PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y generar el PDF
$pdf->Output('factura.pdf', 'I');
?>
