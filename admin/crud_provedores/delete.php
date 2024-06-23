<?php
session_start();
require '../../models/Http.php';
require '../../config.php';
if(isset($_SESSION['id_admin'], $_SESSION['username'], $_SESSION['token'])) {
    $id_admin = $_SESSION['id_admin'];
    $username = $_SESSION['username'];
    $token = $_SESSION['token'];
} else {
    header("Location: ../../catalogo/login.php");
    exit; 
}

$id = $_GET['id'];

HttpClient::setUrl(URL.'/proveedores/delete/'.$id.'/'.$token);
$response = HttpClient::delete();

if ($response['status']) {
  echo '<script>
  alert("Desactivado con éxito!");
  window.location.href = "provedores.php";
</script>';
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
    <title>DELETE</title>
</head>
<body>
    
</body>
</html>