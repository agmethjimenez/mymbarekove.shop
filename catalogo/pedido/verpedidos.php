<?php
include_once '../../database/conexion.php';
$database = new Database();
$conexion = $database->connect();
session_start();
if (!isset($_SESSION['usuario_nombre']) || !isset($_SESSION['usuario_apellido'])) {
    header("Location: login.php");
    exit();
}
    $id_users = $_SESSION['id_usuario'];
    $sql = "SELECT p.idPedido, p.usuario, p.ciudad, p.direccion, p.fecha, e.estado FROM pedidos as p 
    INNER JOIN estados as e ON p.estado = e.codEst WHERE p.usuario = '$id_users'";
    $result = $conexion->query($sql);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #F2E2CE ;
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
    </style>
</head>
<body>
    <header>
        <h1>Tus Pedidos</h1>
    </header>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="order" id="order1">';
                echo '<div class="order-info">';
                echo '<h2>Pedido #'. $row['idPedido'].'</h2>';
                echo '<p class="date">Fecha del Pedido:'.$row['fecha'].'</p>';
                echo '<p class="date">Direccion:'. $row['direccion'].'</p>';
                echo '<p class="date">Ciudad:'. $row['ciudad'].'</p>';
                echo '</div>';
                echo '<a href="detallepedido.php?id='.$row['idPedido'].'" class="details-link">Ver Detalles</a>';
                echo '</div>'; 
            }
        }else{
            echo '<div class="alert"><h1>No tienes pedidos</h1></div>';
        }
        ?>
        <!--<div class="order" id="order1">
            <div class="order-info">
                <h2>Pedido #12345</h2>
                <p class="date">Fecha del Pedido: 2023-01-01</p>
                <p class="date">Ciudad</p>
                <p class="date">Direccion: Cara 70 #2</p>
                <p class="status" data-estado="Finalizado">Estado: Finalizado</p>
            </div>
            <a href="#" class="details-link">Ver Detalles</a>
        </div>

        <div class="order" id="order2">
            <div class="order-info">
                <h2>Pedido #67890</h2>
                <p class="date">Fecha del Pedido: 2023-02-15</p>
                <p class="status" data-estado="Cancelado">Estado: Cancelado</p>
            </div>
            <a href="#" class="details-link">Ver Detalles</a>
        </div>-->

        <!-- Puedes agregar más bloques "order" según sea necesario -->

    </div>

    <script>
        // Función para asignar colores según el estado del pedido
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

        // Obtener todos los elementos de clase 'status'
        var estados = document.querySelectorAll('.status');

        // Iterar a través de cada estado y asignar el color
        estados.forEach(function(estado) {
            var estadoTexto = estado.textContent.trim().split(':')[1].trim();
            asignarColorEstado(estadoTexto, estado);
        });
    </script>

</body>
</html>