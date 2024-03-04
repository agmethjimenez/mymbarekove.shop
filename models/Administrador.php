<?php

class Admin{
    public function Registro($username, $email, $password){
        global $conexion;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $id_admin = substr(uniqid(), 0, 10);
        $sql = "INSERT INTO administradores VALUES (?,?,?,?)";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("ssss",$id_admin,$username,$email,$hashedPassword);

        if($bin->execute()){
            echo '<div class="message is-primary" id="message">';
            echo '<p>Administrador registrado</p>';
            echo '</div>';
        }else{
            echo '<div class="message is-danger" id="message">';
            echo '<p>Administrador no registrado</p>';
            echo '</div>';
        }

    }
    public function LogIn($correo,$contraseña){
        global $conexion;
        $query = "SELECT * FROM administradores WHERE email='$correo' AND activo = 1";
        $result = $conexion->query($query);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['clave'];

                if (password_verify($contraseña, $hashedPassword)) {
                    /*$_SESSION['id_admin'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];*/
                    return["accesso"=> true, "mensaje" => "Verificado correctamente", 'usuario' =>[
                        "id_admin" => $row['id'],
                        "username" => $row['username'],
                        "email" => $row['email']
                    ]];
                } else {          
                    return["accesso" => false, "mensaje" => "Contraseña incorrecta"];

                }
            } else {  
                return["accesso" => false, "mensaje" => "Usuario no encontrado"];

            }
        } else {
            return["accesso" => false, "mensaje" => 'Error en la cosulta = '.$conexion->error.''];
        }

    }
    public function IniciarSesion($correo,$contraseña){
        global $conexion;
        $error_message = " ";
        $query = "SELECT * FROM administradores WHERE email='$correo' AND activo = 1";
        $result = $conexion->query($query);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['clave'];

                if (password_verify($contraseña, $hashedPassword)) {
                    $_SESSION['id_admin'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    header("location: catalogo.php");
                    exit();
                } else {          
                    echo '<div class="message is-danger" id="message">';
                    echo '<p>Contraseña incorrecta</p>';
                    echo '</div>';
                }
            } else {  
                echo '<div class="message is-danger" id="message">';
                echo '<p>Usuario no encontrado</p>';
                echo '</div>';
            }
        } else {
            $error_message = "Error en la consulta: " . $conexion->error;
        }

    }

    public function AgregarMarca($nombre) {
        global $conexion;
        $sql = "INSERT INTO marcas (marca) VALUES (?)";
    
        return $conexion->prepare($sql)->execute([$nombre]);
    }
    public function DesactivarUsuario($id){
        global $conexion;
        $desactivacion1 = "UPDATE usuarios SET activo = 0 WHERE id = ?";
        
        if ($conexion->prepare($desactivacion1)->execute([$id])) {
            $desactivacion2 = "UPDATE credenciales SET activo = 0 WHERE id = ?";
            if($conexion->prepare($desactivacion2)->execute([$id])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
?>