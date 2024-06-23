<?php
session_start();
include '../../config.php';
include '../../models/Http.php';
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $idPedido = $_GET['id'];

    HttpClient::setUrl(URL.'/pedidos/'.$idPedido);
    
    $pedido = HttpClient::get();

    if ($pedido['usuario']['id'] !== $_SESSION['id_usuario']) {
        header("Location: verpedidos.php");
        exit();
    }

} else {
    header("Location: verpedidos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="../imgs/productos/Copia de Logo veterinaria animado azul rosado.png">
    <link rel="stylesheet" href="../css/detallepedido.css">

    <title>Detalle del Pedido</title>
</head>

<body>
    <header>
        <h1>Detalle del Pedido</h1>
    </header>

    <div class="container">
        <div class="order">
            <div class="order-info">
                <h2>Pedido #<?php echo $pedido['idPedido']; ?></h2>
                <p class="date">Fecha del Pedido: <?php echo $pedido['fecha']; ?></p>
                <p class="date">Direccion: <?php echo $pedido['direccion']; ?></p>
                <p class="date">Ciudad: <?php echo $pedido['ciudad']; ?></p>
            </div>
        </div>
        <table class="table" id="orderdetails">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($pedido['detallespedido'])) {
                    foreach ($pedido['detallespedido'] as $detalle) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($detalle['idProducto']) . '</td>';
                        echo '<td>' . htmlspecialchars($detalle['producto']['nombre']) . '</td>';
                        echo '<td>$' . htmlspecialchars($detalle['producto']['precio']) . '</td>';
                        echo '<td>' . htmlspecialchars($detalle['cantidad']) . '</td>';
                        echo '<td>$' . htmlspecialchars($detalle['total']) . '</td>';
                        echo '<td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No hay detalles disponibles</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
        echo "<h1><strong>Total:$" . $pedido['total'] . "</strong></h1>";


        $_SESSION['num_pedido'] = $idPedido;
        ?>
        <h1></h1>
        <div style="display: flex;">
            <a class="button is-warning" href="verpedidos.php" class="details-link">Volver a Tus Pedidos</a>
            <a class="button is-danger" href="../factura.php"><i class="fa-solid fa-file-pdf"></i> Factura</a>
        </div>
        <div class="modal" id="myModal">
            <div class="modal-content">
                <p>¿Estás seguro de cancelar el pedido? Ten en cuenta que no podras deshacer esta accion.</p>
                <div class="button-container">
                    <form action="" method="get">
                        <a class="button is-link" href="#" onclick="closeModal()">Cancelar</a>
                        <a class="button is-danger" href="cancelar_pedido.php?id=<?php echo $idPedido ?>">Confirmar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let modal = document.getElementById("myModal");
        let btn = document.getElementById("btncancelarpedido");

        function openModal() {
            modal.style.display = "flex";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        function asignarColorEstado(estado, elemento) {
            switch (estado.toLowerCase()) {
                case 'finalizado':
                    elemento.style.color = 'green';
                    break;
                case 'cancelado':
                    elemento.style.color = 'red';
                    break;
                case 'pendiente':
                    elemento.style.color = 'yellow';
                    break;
                case 'en proceso':
                    elemento.style.color = 'blue'; // Puedes cambiar el color según tus necesidades
                    break;
                default:
                    elemento.style.color = 'black'; // Color predeterminado
            }
        }

        var estados = document.querySelectorAll('.status');


        estados.forEach(function(estado) {
            var estadoTexto = estado.textContent.trim().split(':')[1].trim();
            asignarColorEstado(estadoTexto, estado);
        });
    </script>
</body>

</html>