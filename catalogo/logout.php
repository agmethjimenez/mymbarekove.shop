<?php
session_start();
session_destroy();
setcookie('id_usuario','', time() -1);
setcookie('usuario_nombre','', time() -1);
setcookie('usuario_apellido','', time() - 1, '/');
header("Location: login.php"); 
exit();
?>
