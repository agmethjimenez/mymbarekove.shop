<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./estilos/update.css">
    <title>Document</title>
</head>
<body>
<div class="contenedor">
    <form action="create.php" method="post">
    <?php
$conexion = new mysqli("localhost", "root", "", "mymba", 3306);
$conexion->set_charset("utf8");

?>
    <div class="title" ><h1>Agregar Usuario</h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">Tipo ID</label>
        <div class="select is-primary" id= "select" name="tipoid">
            <select name="tipoid" id="tipoid">
                <option value="0">Seleccione un tipo de id</option>
                <option value="1">Cedula de Ciudadania</option>
                <option value="2">Cedula de Extranjeria</option>
                <option value="3">Pasaporte</option>
                <option value="4">Permiso Especial de Permanencia</option>
            </select>
        </div>
        </div>
        <div class="con1-2">
        <label for="" class="label">Identificacion</label>
        <input class="input is-primary" type="text"  name="identificacion">
        </div>   
    </div>


        <div class="con2">
            <div class="con2-1">
        <label for="" class="label">Primer nombre</label>
        <input class="input is-primary" type="text" name="nombre1">
        </div>
        <div class="con2-2">
        <label for="" class="label">Segundo nombre</label>
        <input class="input is-primary" type="text" name="nombre2">
        </div>
        </div>
        <div class="con3">
        <div class="con3-1">
        <label for="" class="label">Primer apellido</label>
        <input class="input is-primary" type="text" name="apellido1">
        </div>
        <div class="con3-2">
        <label for="" class="label">Segundo apellido</label>
        <input class="input is-primary" type="text" name="apellido2">
        </div>    
    </div>
        <div class="con4">
            <div class="con4-1">
            <label for="" class="label">Email</label>
        <input class="input is-primary" type="email" name="email">
        </div>
        <div class="con4-2">
        <label for="" class="label">Telefono</label>
        <input class="input is-primary" type="text"  name="telefono">
        </div>    
    </div>
        <div class="con5">
            <div class="con5-1">
        <label for="" class="label">Contraseña</label>
        <input class="input is-primary" name="password" type="password">
        </div>   
    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Agregar</button>
    </div>
    

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = $_POST['identificacion'];
    $cod_id = $_POST['tipoid'];
    $primernombre = $_POST['nombre1'];
    $segundonombre = $_POST['nombre2'];
    $primerapellido = $_POST['apellido1'];
    $segundoapellido = $_POST['apellido2'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['password'];

    $hashed = password_hash($contraseña, PASSWORD_BCRYPT);

    $sqli = "INSERT INTO usuarios VALUES(NULL,'$id_usuario','$cod_id','$primernombre','$segundonombre','$primerapellido','$segundoapellido','$telefono','$email',1,'$hashed');";

if ($conexion->query($sqli) === true) {
    echo '<div class="message is-primary" id="message">';
    echo '<p>Insercion de usuario Exitosa</p>';
    echo '<a href="crud.php" class="button is-primary">Volver</a>';
    echo '</div>';
} else {
    echo "Error al agregar el usuario: "          ;         
    echo '<div class="message is-danger" id="message">';
    echo '<p>Insercion de usuario no exitosa</p>';
    echo $conexion->error;
    echo '<a href="crud.php" class="button is-primary">Volver</a>';
    echo '</div>';
}
}

    ?>
    </div>
    </form>
    </body>
</html>