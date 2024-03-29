<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
        }


        header a {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            text-decoration: none;
        }

        main {
            display: flex;
        }

        aside {
            width: 250px;
            height: 100vh;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        section {
            flex: 1;
            padding: 20px;
        }

        aside h2 {
            margin-bottom: 20px;
            color: #333;
        }
        aside nav{
            height: 80%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        nav a {
            display: flex;
            padding: 10px;
            text-decoration: none;
            color: #333;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #ddd;
        }

        .user-info {
            flex: 1;
            padding: 20px;
        }

        @media (max-width: 768px) {
            main {
                flex-direction: column;
            }

            aside {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>

    <header>
        <a href="../../catalogo/catalogo.php"><i class="fas fa-arrow-left"></i></a>
        <h1>Panel de Administrador</h1>
    </header>

    <main>
        <aside>
            <nav>
                <a href="../pedidos/pedidos.php">Pedidos</a>
                <a href="../crud_users/crud.php">Usuarios</a>
                <a href="../crud_produ/productos.php">Productos</a>
                <a href="../crud_provedores/provedores.php">Proveedores</a>
                <a href="../admin_action/admins.php">Administradores</a>
            </nav>
        </aside>
        <section class="user-info">
        <h2>Información del Administrador</h2>
            <p>Correo: admin@example.com</p>
            <p>Nombre: Admin Nombre</p>
            <p>ID: 123456</p>
        </section>
    </main>

</body>
</html>
