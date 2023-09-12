
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
    <form action="update.php" method="post">
    <?php
$conexion = new mysqli("localhost", "root", "", "mymba", 3306);
$conexion->set_charset("utf8");
if($_SERVER["REQUEST_METHOD"] === "GET"){
$id = $_GET["id"];
$sql = "SELECT * FROM usuarios WHERE id='$id'";
$result = $conexion->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
}}
?>
    <div class="title" ><h1>Actualizar Datos</h1></div>
        <div class="con1">
            <div class="con1-1">
        <label for="" class="label">ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>" name="id" readonly>
        </div>
        <div class="con1-2">
        <label for="" class="label">Identificacion</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['identificacion']) ? $row['identificacion'] : ''; ?>" name="identificacion" readonly>
        </div>   
    </div>
        <div class="con2">
            <div class="con2-1">
        <label for="" class="label">Tipo de ID</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['tipoId']) ? $row['tipoId'] : ''; ?>" name="tipoid">
        </div>
        <div class="con2-2">
        <label for="" class="label">Primer nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['primerNombre']) ? $row['primerNombre'] : ''; ?>" name="nombre1">
        </div>
        </div>
        <div class="con3">
            <div class="con3-1">
        <label for="" class="label">Segundo nombre</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['segundoNombre']) ? $row['segundoNombre'] : ''; ?>" name="nombre2">
        </div>
        <div class="con3-2">
        <label for="" class="label">Primer apellido</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['primerApellido']) ? $row['primerApellido'] : ''; ?>" name="apellido1">
        </div>    
    </div>
        <div class="con4">
            <div class="con4-1">
        <label for="" class="label">Segundo apellido</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['segundoApellido']) ? $row['segundoApellido'] : ''; ?>" name="apellido2">
        </div>
        <div class="con4-2">
        <label for="" class="label">Email</label>
        <input class="input is-primary" type="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" name="email">
        </div>    
    </div>
        <div class="con5">
            <div class="con5-1">
        <label for="" class="label">Telefono</label>
        <input class="input is-primary" type="text" value="<?php echo isset($row['telefono']) ? $row['telefono'] : ''; ?>" name="telefono">
        </div>   
    </div>
    <div class="butcon">
    <button class="button is-success" type="submit">Actualizar</button>
    </div>
    

<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $ida = $_POST['id'];
    $id_usuario = $_POST['identificacion'];
    $cod_id = $_POST['tipoid'];
    $primernombre = $_POST['nombre1'];
    $segundonombre = $_POST['nombre2'];
    $primerapellido = $_POST['apellido1'];
    $segundoapellido = $_POST['apellido2'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    $sqli = "UPDATE usuarios 
    SET id ='$ida', identificacion = '$id_usuario',
    tipoId = '$cod_id',
    primerNombre = '$primernombre',
    segundoNombre = '$segundonombre',
    primerApellido = '$primerapellido',
    segundoApellido = '$segundoapellido',
    email = '$email',
    telefono = '$telefono' 
    WHERE id ='$ida';";

if ($conexion->query($sqli) === true) {
    echo '<div class="message is-primary" id="message">';
    echo '<p>Actualización exitosa</p>';
    echo '<a href="crud.php" class="button is-primary">Volver</a>';
    echo '</div>';

    $sql = "SELECT * FROM usuarios WHERE id='$ida'";
    $result = $conexion->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
    } else {
        echo "Error al cargar los datos actualizados";
        
    }
} else {
    echo "Error al actualizar el usuario: " . $conexion->error;
}
}

    ?>
    </div>
    </form>
    </body>
</html>