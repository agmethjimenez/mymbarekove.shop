<?
session_start();
if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['email'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../crud_produ/estyles/cri.css">
    <title>Pedidos</title>
</head>

<body>
    <div class="title" style="padding: 20px; display: flex; justify-content: space-between; color:white;">
        <h1>Pedidos</h1>
    </div>
    <div class="tata">
        <table class="table" style="width: 90%;">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Usuario</th>
                    <th>Ciudad</th>
                    <th>Dirección</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="pedidoTableBody">
            </tbody>
        </table>
    </div>

    <script src="../../config.js"></script>
<script>
    fetch(`http://${URLS}/controller/pedido.php`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('pedidoTableBody');

            data.map(pedido => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${pedido.idPedido}</td>
                    <td>${pedido.nombreCompleto}</td>
                    <td>${pedido.ciudad}</td>
                    <td>${pedido.direccion}</td>
                    <td>${pedido.fecha}</td>
                    <td>$${pedido.total}</td>
                    <td>${pedido.estado}</td>
                    <td><a href="update.php?id=${pedido.idPedido}" class="button is-link">Ver/Editar</a></td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error al obtener los datos de pedidos:', error));
</script>

</body>

</html>
