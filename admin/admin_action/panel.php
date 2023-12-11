<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
        }

        .admin-option {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .admin-option:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Panel de Administrador</h2>

        <div class="admin-option">
            <a class="button is-primary" href="http://localhost/mymbarekove.shop/mymba/mymba/admin/crud_produ/productos.php">Administrar Productos</a>
        </div>

        <div class="admin-option">
            <a class="button is-primary" href="#">Administrar Proveedores</a>
        </div>

        <div class="admin-option">
            <a class="button is-primary" href="#">Administrar Usuarios</a>
        </div>

        <div class="admin-option">
            <a class="button is-primary" href="#">Agregar Administrador</a>
        </div>
    </div>

</body>
</html>
