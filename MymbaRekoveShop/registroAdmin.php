<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registro.css">
    <title>Document</title>
</head>
<body>
    <form action="registroAdmincon.php" method="post">
        <table>
        <div class="container">
            <tr align="right">
                <td></td>
                <td></td>
                <td></td>
                <td align="left"><h1>Registro</h1></td>  
                <td></td>      
                <td></td>
                <td></td>
          </tr>
        <tr>
            <td align="right"><label for="id_usuario">Identificacion</label></td>
            <td><input type="text" id="id_usuario" name="id_usuario" placeholder="123456789"></td>
            <td align="right"><p><label for="">Tipo de Rol</label></p></td>
        <td align="left"><select  name="tipo_registro" id="tipo_registro">
            <option value="0">Seleccione</option>
            <option value="1">Cliente</option>
            <option value="2">Proveedor</option>
            <option value="3">Asesor</option>
            <option value="4">Encargado</option>
        </tr>
            <tr>
        <td align="right"><p><label for="">Tipo de Identificacion</label></p></td>
        <td><select name="tipo_id" id="tipo_id">
            <option value="0">Seleccione</option>
            <option value="1">Tarjeta de Identidad</option>
            <option value="2">Cedula de Ciudadania</option>
            <option value="3">Cedula de Extranjeria</option>
            <option value="4">PASAPORTE</option>
            <option value="5">PEP</option>

           
            
        </select></td>   
        <td align="right"><p><label for="nombre">Primer Nombre</label></p></td>
        <td><input type="text" id="nombre" name="nombre" placeholder="Primer nombre" required></td>
        <br><br>
        <td align="right"><p><label for="Snombre">Segundo Nombre</label></p></td>
        <td><input type="text" id="Snombre" name="Snombre" placeholder="Segundo nombre" required></td>
          
        </tr>
    
    
        <tr>
            <td align="right"><p> <label for="email">Correo Electronico </label></p></td>
            <td><input type="text" id="email" name="email" placeholder="usuario@correo.com" required></td>
            <td align="right"><p><label for="apellido">Primer Apellido</label></p></td>
            <td><input type="text" id="apellido" name="apellido" placeholder="Primer Apellido" required></td>
            <td align="right"><p><label for="Sapellido">Segundo Apellido</label></p></td>
            <td><input type="text" id="Sapellido" name="Sapellido" placeholder="Segundo Apellido" required></td>
           
            
        </tr>
        <tr>

            <td align="right"><p><label for="numero">Numero de telefono</label></p></td>
            <td><input type="text" id="numero" name="numero" placeholder="EJ:3123456789"></td>
            <td align="right"><p><label for="">Contraseña</label></p></td>
            <td><input type="password" id="password" name="password" placeholder="EJ:123456789"></td><br><br>
            <td align="right"><p><label for="">Confirmar Contraseña</label></p></td>
            <td><input type="password" id="repassword" name="repassword" placeholder="EJ:123456789"></td><br><br>
        </tr>
    
        <tr>
        <td align="right"><a href="">¿Ya estas registrado?</a><br></td>
        <TD align="right"><br></TD><br><br>
        <td><p><p></p></p></td>
        
        
        </tr>
    
    
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <TD></TD>
            <td align="right"><input type="submit" id="submit" value="Ingresar"></td><br><br><br><br>
        </tr>
        </div>
    </table>
    </form>
</body>
</html>