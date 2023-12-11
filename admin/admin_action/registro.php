<!DOCTYPE html>
<?php
require '../../database/conexion.php';
require_once("../../models/administrador.php");
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
    body{
        background-color: black;
        font-family: 'Oxygen', sans-serif;
        padding: 0;
        margin: 0;
        height: 100vh;
    }
    .contenedor{
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    form{
        background-color: #fff;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 30px;
        width: 25%;
        border-radius: 20px;
        
    }
    input[type="text"],input[type="email"],input[type="password"]{
        border-radius: 15px;
    }
</style>
<body>
    <div class="contenedor">

        <form action="registro.php" method="post">
            <div class="title">
            <h1>Registro de administrador</h1>
            </div>
            
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
                <button type="submit" class="button is-success">Registrar</button>
            </div>
            <?php
require_once(__DIR__ . '/../../database/conexion.php');
$database = new Database();
$conexion = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (empty($username) || empty($email) || empty($password)) {
        echo '<div class="message is-danger" id="message">';
        echo '<p>Por favor, completa todos los campos del formulario.</p>';
        echo '</div>';
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $id_admin = substr(uniqid(), 0, 10);

    $sql = "INSERT INTO administradores VALUES (?,?,?,?,1)";
    $bin = $conexion->prepare($sql);

    if (!$bin) {
        echo '<div class="message is-danger" id="message">';
        echo '<p>Error al preparar la consulta: ' . $conexion->error . '</p>';
        echo '</div>';
        exit();
    }

    $bin->bind_param("ssss", $id_admin, $username, $email, $hashedPassword);

    if ($bin->execute()) {
        echo '<div class="message is-primary" id="message">';
        echo '<p>Administrador registrado correctamente</p>';
        echo '</div>';
    } else {
        echo '<div class="message is-danger" id="message">';
        echo '<p>Error al registrar el administrador: ' . $bin->error . '</p>';
        echo '</div>';
    }

    $bin->close();
    $conexion->close();
}
?>

    </form>
    </div>
</body>

</html>