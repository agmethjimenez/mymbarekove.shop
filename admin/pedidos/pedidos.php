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
                <!-- Datos de pedidos se mostrarán aquí -->
            </tbody>
        </table>
    </div>

    <script>
        // Fetch para obtener los datos de pedidos
        fetch('http://localhost/mymbarekove.shop/controller/pedido.php')
            .then(response => response.json())
            .then(data => {
                // Manipular los datos y construir filas de la tabla
                const tableBody = document.getElementById('pedidoTableBody');

                data.forEach(pedido => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${pedido.idPedido}</td>
                        <td>${pedido.usuario}</td>
                        <td>${pedido.ciudad}</td>
                        <td>${pedido.direccion}</td>
                        <td>${pedido.fecha}</td>
                        <td>$${pedido.total}</td>
                        <td>${pedido.estado}</td>
                        <td><a href="update.php?id=${pedido.idPedido}" class="button is-link">Ver/Editar</a> <a href="delete.php?id=${pedido.idPedido}" class="button is-danger">Desactivar</a></td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error al obtener los datos de pedidos:', error));
    </script>

</body>

</html>
