<?php
// Incluye el archivo de autoloader de Composer desde la raíz del proyecto


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Resto del código aquí

// Crear una instancia de PHPMailer
$mail = new PHPMailer(true);

// Configurar el servidor SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'shopmymbarekove@gmail.com'; // Reemplaza con tu dirección de Gmail
$mail->Password = 'qpfn ppwz mqab fhuu'; // Reemplaza con tu contraseña de Gmail
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Puedes usar PHPMailer::ENCRYPTION_SMTPS si prefieres SSL
$mail->Port = 587; // Usa el puerto 465 si estás usando SSL

// Configurar el remitente y destinatario
$mail->setFrom('tudireccion@gmail.com', 'Verificacion de email');
$mail->addAddress($email);

$codigo = rand(1000,9999);
// Configurar el contenido del mensaje
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
  <h1>Verificacion</h1><br>
  <p>Este es una verificacion de existencia de correo</p><br>
</body>
</html>
';

$enviado = false; // Inicializamos como false

try {
    // Enviar el correo
    $mail->send();
    $enviado = true; // Marcamos como true si se envió correctamente
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}

// Ahora $enviado será true si se envió correctamente, de lo contrario, será false.
?>
