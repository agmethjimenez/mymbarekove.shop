<?php

$id_usuario = $_POST['id_usuario'];
$cod_id = $_POST['tipo_id'];
$tipo_registro = $_POST['tipo_registro'];
$primernombre = $_POST['nombre'];
$segundonombre = $_POST['Snombre'];
$primerapellido = $_POST['apellido'];
$segundoapellido = $_POST['Sapellido'];
$email = $_POST['email'];
$telefono = $_POST['numero'];
$contrasena = $_POST['password'];


$database = "mymba";
$user = 'root';
$password = '';

try {
    $conn = new PDO('mysql:host=localhost;dbname=' . $database, $user, $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $RolTable = '';
    if ($tipo_registro == '1'){
        $RolTable = 'clientes';
        $TID = 'id_cliente';
    } elseif($tipo_registro == '2'){
           $RolTable = 'proveedor';
           $TID = 'id_proveedor';
    } elseif ($tipo_registro == '3'){
        $RolTable = 'asesores'; 
        $TID = 'id_asesor';   
    } elseif ($tipo_registro == '4'){
        $RolTable = 'encargados';
        $TID = 'id_encargado';
    }
   
    $sql = "INSERT INTO usuarios (id_usuario, cod_id,cod_rol, primernombre, segundonombre, primerapellido, segundoapellido, correo, telefono, contraseña)
            VALUES ('$id_usuario', '$cod_id','$tipo_registro', '$primernombre', '$segundonombre', '$primerapellido', '$segundoapellido', '$email', '$telefono', '$contrasena')";
    $sqli = "INSERT INTO $RolTable ($TID) VALUES('$id_usuario')";

    $conn->beginTransaction();
    if ($conn->exec($sql)) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar el usuario";
    }
    if ($conn->exec($sqli)) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar el usuario";
    }
    $conn -> commit();
} catch (PDOException $e) {
    $conn -> rollBack();
    echo "Error: " . $e->getMessage();
}


$conn = null;
?>
