<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['email'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit;
}
require_once '../../database/conexion.php';
require_once("../../models/administrador.php");
$database = new Database();
$conexion = $database->connect();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="">
    <title>Document</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Oxygen&display=swap');

    body {
        background-color: black;
        font-family: 'Oxygen', sans-serif;
        padding: 0;
        margin: 0;
        height: 100vh;
    }

    .contenedor {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    form {
        background-color: #fff;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 30px;
        width: 25%;
        border-radius: 20px;

    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        border-radius: 15px;
    }
</style>

<body>
    <div class="contenedor">

        <form action="registro.php" method="post">
            <div class="title">
                <h1>Registro de administrador</h1>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                $errors = [];

                $username = $_POST['username'];
                if (empty($username)) {
                    $errors[] = "El nombre de usuario es obligatorio.";
                }

                $email = $_POST['email'];
                if (empty($email)) {
                    $errors[] = "El correo electrónico es obligatorio.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "El correo electrónico no es válido.";
                }

                $password = $_POST['password'];
                if (empty($password)) {
                    $errors[] = "La contraseña es obligatoria.";
                } elseif (strlen($password) < 6) {
                    $errors[] = "La contraseña debe tener al menos 6 caracteres.";
                }

                if (empty($errors)) {
                    $registrar = Admin::Registro($conexion, $username, $email, $password);

                    if ($registrar) {
            ?>
                        <div class="notification is-primary is-light">
                            <button class="delete"></button>
                            Administrador registrado exitosamente
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="notification is-danger is-light">
                            <button class="delete"></button>
                            Error al registrar administrador
                        </div>
                    <?php
                    }
                } else {
                    foreach ($errors as $error) {
                    ?>
                        <div class="notification is-danger is-light">
                            <button class="delete"></button>
                            <?php echo $error; ?>
                        </div>
            <?php
                    }
                }
            }
            ?>
            <!--CAMPO USERNAME-->
            <div class="field">
                <p class="control has-icons-left has-icons-right">
                    <input class="input is-primary" type="text" placeholder="Username" name="username" required>
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-user-tie"></i>
                    </span>
                    </span>
                </p>
            </div>
            <!--Campo Email-->
            <div class="field">
                <p class="control has-icons-left has-icons-right">
                    <input class="input is-primary" type="email" placeholder="Email" name="email" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                    </span>
                </p>
            </div>
            <!--CAMPO PASSWORD-->
            <div class="field">
                <p class="control has-icons-left has-icons-right">
                    <input class="input is-primary" type="password" placeholder="Password" name="password" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                    </span>
                </p>
            </div>
            <!--Boton-->
            <div class="butto">
                <button type="submit" name="submit" class="button is-success">Registrar</button>
            </div>
        </form>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
            const $notification = $delete.parentNode;

            $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
            });
        });
    });
</script>

</html>