
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="iniciosesion.css">
    <title>Document</title>
</head>
<body>
<?php include("iniciopp.php")?>

    <form action="" method="post">
    <table>
    <div class="container">
        <tr><td align="center"><h1>Bienvenido</h1></td></tr>
        <tr>
       <td align="right"><p> <label for="email">Correo Electronico </label></p></td>
      <td><input type="text" id="email" name="email" placeholder="usuario@correo.com" ></td>
    </tr>


    <tr>
        <td align="right"><p><label for="">Contraseña</label></p></td>
        <td><input type="password" id="password" name="password" placeholder="EJ:123456789"></td><br><br>
    </tr>


    <tr>
    <td align="right"><a href="">Recuperar Clave</a><br></td>
    <TD align="right"><a href="registroform.php">¿No te has registrado?</a><br></TD><br><br>
    </tr>

    <tr>
    <td colspan="2" align="center">
                        <?php if (!empty($error_message) && isset($_POST["submit"])) : ?>
                            <span id="error-message" class="error-message"><?php echo $error_message; ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
    <tr>
    <td></td>
        <td align="right"><input type="submit" name="submit" id="submit" value="Ingresar"></td><br><br><br><br>
    </tr>
    </div>
</table>
</form>
</body>
</html>