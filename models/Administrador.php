<?php

class Admin{
    
    private $id;
    private $username;
    private $email;

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
    
    public function AgregarMarca($nombre) {
        global $conexion;
        $sql = "INSERT INTO marcas (marca) VALUES (?)";
    
        return $conexion->prepare($sql)->execute([$nombre]);
    }
    public function DesactivarUsuario($conexion,$id) {
        $desactivacion1 = "UPDATE usuarios SET activo = 0 WHERE id = ?";
        $stmt1 = $conexion->prepare($desactivacion1);
        $stmt1->bind_param("i", $id);
    
        if (!$stmt1->execute()) {
            return ["acceso" => false, "mensaje" => "Error al ejecutar la consulta: " . $stmt1->error];
        }
    
        $desactivacion2 = "UPDATE credenciales SET activo = 0 WHERE id = ?";
        $stmt2 = $conexion->prepare($desactivacion2);
        $stmt2->bind_param("i", $id);
    
        if (!$stmt2->execute()) {
            return ["acceso" => false, "mensaje" => "Error al ejecutar la consulta: " . $stmt2->error];
        }
        return ["acceso" => true, "mensaje" => "Desactivado Correctamente"];
    }
}
?>
