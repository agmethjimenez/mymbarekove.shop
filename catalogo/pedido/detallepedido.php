<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();
session_start();

if (!isset($_SESSION['usuario_nombre']) || !isset($_SESSION['usuario_apellido'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $idPedido = $_GET['id'];
    $idUsuario = $_SESSION['id_usuario'];

    // Consulta para obtener detalles del pedido
    $sqlDetalles = "SELECT dp.idProducto, p.nombre, p.precio, dp.cantidad, dp.total 
                    FROM detallepedido as dp
                    INNER JOIN productos as p ON dp.idProducto = p.idProducto
                    WHERE dp.idPedido = '$idPedido'";

    
    $resultDetalles = $conexion->query($sqlDetalles);

    // Consulta para obtener información general del pedido
    $sqlPedido = "SELECT p.idPedido, p.usuario, p.ciudad, p.direccion, p.fecha, e.estado as estad FROM pedidos as p 
    INNER JOIN estados as e ON p.estado = e.codEst WHERE p.idPedido = ? AND p.usuario = ?";

    $stmtPedido = $conexion->prepare($sqlPedido);
    $stmtPedido->bind_param("ss", $idPedido, $idUsuario);
    $stmtPedido->execute();
    $resultPedido = $stmtPedido->get_result();

    // Verificar si el pedido existe y pertenece al usuario actual
    if ($resultPedido->num_rows > 0) {
        $pedido = $resultPedido->fetch_assoc();
    } else {
        // Redirigir si el pedido no existe o no pertenece al usuario
        header("Location: tuspedidos.php");
        exit();
    }
} else {
    // Redirigir si no se proporciona un ID de pedido válido
    header("Location: tuspedidos.php");
    exit();
}
/*$pruebapedido = false;
if($pedido['estad'] != "Cancelado" ){
    $pruebapedido = true;
}
$pruebaeditarpedido = false;
if($pedido['estad'] = "Pendiente" ){
    $pruebaeditarpedido = true;
}*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Detalle del Pedido</title>
    <style>
        /* Estilos CSS similares a los usados anteriormente */
    </style>
</head>
<style>
     body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;            
        background: #F2E2CE ;
        height: 100vh;
        overflow-y: auto;
    }
    header {
        background-color: #594A3C;
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
            color: green; /* Puedes cambiar el color según el estado (cancelado, finalizado, etc.) */
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
                <p class="status" data-estado=<?php echo $pedido['estad'] ?>>Estado: <?php echo $pedido['estad']; ?></p>
            </div>
        </div>
        <?php
        $pruebapedido = false;
        if($pedido['estad'] != "Cancelado" && $pedido['estad'] != "Finalizado" && $pedido['estad'] != "Vencido" && $pedido['estad'] != "En proceso" ){
            $pruebapedido = true;
        }
        $pruebaeditarpedido = false;
        if($pedido['estad'] == "Pendiente"){
            $pruebaeditarpedido = true;
        }
        ?>
        <table  class="table" id="order-details">
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <?php if($pruebapedido){ ?>
                    <th>Acciones</th>
                         <?php } ?>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultDetalles->num_rows > 0) {
                    while ($detalle = $resultDetalles->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($detalle['idProducto']) . '</td>';
                        echo '<td>' . htmlspecialchars($detalle['nombre']) . '</td>';
                        echo '<td>$' . htmlspecialchars($detalle['precio']) . '</td>';
                        echo '<td>' . htmlspecialchars($detalle['cantidad']) . '</td>';
                        echo '<td>$' . htmlspecialchars($detalle['total']) . '</td>';
                        if ($pruebapedido) {
                        echo '<td><a href="borrarproducto.php?pedido='. $idPedido.'&producto='. $detalle['idProducto'] .'" class="button is-black">Quitar</a><a href="restarproducto.php?pedido='. $idPedido.'&producto='. $detalle['idProducto'] .'" class="button is-black">-</a> <a href="sumarproducto.php?pedido='. $idPedido.'&producto='. $detalle['idProducto'] .'" class="button is-black">+</a> </td>' ;
                        }
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
        $tottQuery = "SELECT SUM(dp.total) AS total_pedido FROM detallepedido as dp WHERE dp.idPedido = '$idPedido'";
        $resultTott = $conexion->query($tottQuery);
        
        // Verificar si la consulta fue exitosa
        if ($resultTott) {
            // Obtener el resultado como un array asociativo
            $totalRow = $resultTott->fetch_assoc();
        
            // Obtener el total
            $total_pedido = $totalRow['total_pedido'];
        
            // Imprimir el total
            echo "<h1><strong>Total:$$total_pedido</strong></h1>";
        } else {
            // Manejar el error si la consulta no fue exitosa
            echo "Error en la consulta: " . $conexion->error;
        }
        ?>
        <h1></h1>
        <a class="button is-warning" href="verpedidos.php" class="details-link">Volver a Tus Pedidos</a>
        <?php if($pruebaeditarpedido){ ?>
        <a href="agregarapedido.php?pedido=<?php echo $idPedido  ?>" class="button is-link" class="details-link">Agregar</a>
        <?php } ?>
        <?php if($pruebapedido){?>
        <a class="button is-danger" id="btncancelarpedido" onclick="openModal()" class="details-link">Cancelar Pedido</a>
        <?php }?>
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

