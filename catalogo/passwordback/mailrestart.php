<?php
require '../../config.php';
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'shopmymbarekove@gmail.com'; 
$mail->Password = 'qpfn ppwz mqab fhuu'; 
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
$mail->Port = 587; 

// Configurar el remitente y destinatario
$mail->setFrom('tudireccion@gmail.com', 'Recuperar');
$mail->addAddress($email);

$codigo = rand(1000,9999);
$mail->isHTML(true);
$mail->Subject = 'Mymba Rekove.Shop';
$mail->Body = '
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recordatorio de cumpleaños para Agosto</title>
</head>
<body>
  <h1>Restablecer contraseña</h1><br>
  <p>Tu código es '. $codigo .'</p><br>
  <a href="http://'.URL.'/catalogo/passwordback/codigo.php?email='.$email.'&token='.$token.'">Da clic aquí para actualizar</a>
</body>
</html>
';

$enviado = false; 

try {
    $mail->send();
    $enviado = true; 
    echo '<script>alert("Verifica tu correo")</script>';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}

?>
