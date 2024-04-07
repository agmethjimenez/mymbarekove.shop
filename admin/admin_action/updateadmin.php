<!DOCTYPE html>
<html lang="en">
<?php
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
    <?php
    include '../../database/conexion.php';
    $database = new Database();
    $conexion = $database->connect();
    $id = $_GET['id'];

    $sql = "SELECT*FROM administradores WHERE id = ? AND activo = 1";
    $bin = $conexion->prepare($sql);
    $bin->bind_param("s", $id);
    $result = $bin->execute();
    $result = $bin->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
    }
    ?>
    <div class="contenedor">
        <form action="registro.php" method="post">
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
                <button type="submit" class="button is-success">Registrar</button>
            </div>
        </form>
    </div>
</body>

</html>