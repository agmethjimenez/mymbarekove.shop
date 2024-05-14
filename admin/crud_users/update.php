<?php
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
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
    <link rel="stylesheet" href="./estilos/update.css">
    <title>Document</title>
</head>
<body>
<div class="contenedor">
    <form action="update.php" method="post">
    <?php
require '../../database/conexion.php';
$database = new Database;
$conexion = $database->connect();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET["id"];

    $sql = "SELECT * FROM usuarios WHERE id = :id";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
    } else {
        echo "No se encontró ningún usuario con el ID proporcionado.";
    }
}
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

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/mymbarekove.shop/controller/users',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode(array(
            "id" => $ida,
            "identificacion" => $id_usuario,
            "primerNombre" => $primernombre,
            "segundoNombre" => $segundonombre,
            "primerApellido" => $primerapellido,
            "segundoApellido" => $segundoapellido,
            "telefono" => $telefono,
            "email" => $email
        )),
        CURLOPT_HTTPHEADER => array(
            'token: Bearer '.$_ENV['API_POST_USER'].'',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $response_data = json_decode($response, true);

    if ($response_data && $response_data['exito']) {
        echo '<div class="message is-success" id="message">';
        echo '<p>' . $response_data['message'] . '</p>';
        echo '<a href="./crud.php">Volver</a>';
        echo '</div>';
    } else {
        echo '<div class="message is-danger" id="message">';
        echo '<p>Error en la actualización: ' . ($response_data['message'] ?? 'No se pudo completar la solicitud') . '</p>';
        echo '</div>';
    }

    curl_close($curl);
}

    ?>
    </div>
    </form>
    </body>
</html>