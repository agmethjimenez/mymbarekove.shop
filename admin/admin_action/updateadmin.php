<?php
session_start();
include '../../config.php';
include '../../models/Http.php';
if (isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
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
    <title>Actualizar Admin</title>
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
    <?php
    $id = $_GET['id'];


    HttpClient::setUrl(URL . '/admin/read');
    HttpClient::setBody(['tk' => $id]);
    $row = HttpClient::get();
    ?>
    <div class="contenedor">
        <form action="" method="post">
            <?php
            if (isset($_POST['submit'])) {
                $usernam_admin = $_POST['username'];
                $email_admin = $_POST['email'];
                $url = URL . '/admin/update' ;
                HttpClient::setUrl($url);
                HttpClient::setBody(['token' => $id, 'username' => $usernam_admin, 'email' => $email_admin]);
                $restult = HttpClient::put();

                if ($restult['status']) {
            ?>
                    <div class="notification is-primary is-light">
                        <button class="delete"></button>
                        Administrador actualizado exitosamente <br>
                        <a href="./admins.php">Volver</a>
                    </div>
                <?php
                } else {
                ?>
                    <div class="notification is-danger is-light">
                        <button class="delete"></button>
                        Error al actualizar administrador
                    </div>
            <?php
                }
            }
            ?>
            <div class="title">
                <h1>Actualizar administrador</h1>
            </div>

            <!--CAMPO USERNAME-->
            <div class="field">
                <p class="control has-icons-left has-icons-right">
                    <input class="input is-primary" type="text" placeholder="Username" name="username" value="<?php echo $row['username']; ?>" required>
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-user-tie"></i>
                    </span>
                    </span>
                </p>
            </div>
            <!--Campo Email-->
            <div class="field">
                <p class="control has-icons-left has-icons-right">
                    <input class="input is-primary" type="email" placeholder="Email" name="email" value="<?php echo $row['email']; ?>" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
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