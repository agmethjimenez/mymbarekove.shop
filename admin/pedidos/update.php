<?php
session_start();
include '../../models/Http.php';
include '../../config.php';
if (isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit;
}
if (isset($_GET['id'])) {
    $idPedido = $_GET['id'];

    HttpClient::setUrl(URL . '/pedidos/' . $idPedido);
    $pedido = HttpClient::get();
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Detalle del Pedido</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: black;
        ;
        height: 100vh;
        overflow-y: auto;
    }

    header {
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 10px;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        height: 100%;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .order {
        border-bottom: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-info {
        flex: 1;
    }

    .order h2 {
        margin-bottom: 5px;
    }

    .order .date {
        color: #777;
    }

    .order .status {
        font-weight: bold;
        color: green;
        /* Puedes cambiar el color según el estado (cancelado, finalizado, etc.) */
    }

    .details-link {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .alert {
        background-color: #ffcccc;
        color: #cc0000;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        max-width: 400px;
        margin: 0 auto;
        text-align: center;
    }

    .button-container {
        margin-top: 20px;
    }

    .button {
        margin: 0 10px;
    }
</style>

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
                <p class="status" data-estado=<?php echo $pedido['estado']['estado'] ?>>Estado: <?php echo $pedido['estado']['estado']; ?></p>
            </div>
            <div class="edit">
                <form action="" method="post">
                    <div class="select is-warning">
                        <select class="select" name="estado" id="estado">
                            <option value="<?php echo htmlspecialchars($pedido['estado']['estado'], ENT_QUOTES, 'UTF-8'); ?>" selected>
                                <?php echo htmlspecialchars($pedido['estado']['estado'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                            <?php
                            // Asegúrate de manejar cualquier posible excepción al llamar a la API.
                            try {
                                HttpClient::setUrl(URL . '/estados');
                                $estados = HttpClient::get();

                                foreach ($estados as $estado) {
                                    $estadoID = htmlspecialchars($estado['codEst'], ENT_QUOTES, 'UTF-8');
                                    $nombreEstado = htmlspecialchars($estado['estado'], ENT_QUOTES, 'UTF-8');
                                    echo '<option value="' . $estadoID . '">' . $nombreEstado . '</option>';
                                }
                            } catch (Exception $e) {
                                echo '<option value="">Error al cargar los estados</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <button class="button is-warning" type="submit">Cambiar</button>
                    <?php
                    if (isset($_POST['estado'])) {

                        $estadoaActualizar = $_POST['estado'];
                        $urkl = URL . '/pedidos/update/' . $idPedido . '/' . $estadoaActualizar . '/' . $token;
                        HttpClient::setUrl($urkl);
                        $response = HttpClient::put();

                        if ($response['status']) {
                            echo '<script type="text/javascript">';
                            echo 'Swal.fire({';
                            echo 'icon: "success",';
                            echo 'title: "Éxito",';
                            echo 'text: "' . addslashes($response['mensaje']) . '"';
                            echo '});';
                            echo '</script>';
                        } else {
                            echo '<script type="text/javascript">';
                            echo 'Swal.fire({';
                            echo 'icon: "error",';
                            echo 'title: "Error",';
                            echo 'text: "' . addslashes($response['mensaje']) . '"';
                            echo '});';
                            echo '</script>';
                        }                        
                    }
                    ?>

                </form>

            </div>
        </div>
        <table class="table" id="order-details">
            <thead>
                <tr>
                    <th>ID Producto</th>
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
        echo "<h1><strong>Total: $" . $pedido['total'] . "</strong></h1>";
        ?>
        <h1></h1>
        <a class="button is-warning" href="pedidos.php" class="details-link">Volver</a>
        <a href="factura.php?id=<?php echo $pedido['idPedido']; ?>" class="button is-danger">Factura</a>
        <div class="modal" id="myModal">
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