<?php

class Admin{
    
    private $id;
    private $username;
    private $email;
    private $token;
    
    public function setId($id){
        $this->id = $id;
    }
    public function setUsername($username){
        $this->username = $username;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setToken($token){
        $this->token = $token;
    }

    public function getAdmin($conexion){
        $sql = "SELECT * FROM administradores WHERE id = ? AND token = ?";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("ss", $this->id, $this->token);
        $bin->execute();
        $result = $bin->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Obtener la primera fila como un array asociativo
            return json_encode($row); // Devolver los datos como un array asociativo
        } else {
            return false;
        }
    }
    

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
    public function LogIn($correo, $contraseña){
        global $conexion;
        $query = "SELECT * FROM administradores WHERE email=? AND activo=1";
        $statement = $conexion->prepare($query);
        $statement->bind_param("s", $correo);
        $statement->execute();
        $result = $statement->get_result();
        if ($result !== false) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['clave'];
                if (password_verify($contraseña, $hashedPassword)) {
                    return [
                        "accesso" => true,
                        "mensaje" => "Verificado correctamente",
                        'usuario' => [
                            "id_admin" => $row['id'],
                            "username" => $row['username'],
                            "token" => $row['token'],
                            "email" => $row['email']
                        ]
                    ];
                } else {
                    return ["accesso" => false, "mensaje" => "Contraseña incorrecta"];
                }
            } else {
                return ["accesso" => false, "mensaje" => "Usuario no encontrado"];
            }
        } else {
            return ["accesso" => false, "mensaje" => 'Error en la consulta: ' . $conexion->error];
        }
    }
    
    
    public function AgregarMarca($nombre) {
        global $conexion;
        $sql = "INSERT INTO marcas (marca) VALUES (?)";
    
        return $conexion->prepare($sql)->execute([$nombre]);
    }
    public function DesactivarUsuario($conexion, $id) {
        if ($id === null) {
            return ["acceso" => false, "mensaje" => "No se proporcionó un ID"];
        } 
        $desactivacion1 = "UPDATE usuarios SET activo = 0 WHERE id = ?";
        $stmt1 = $conexion->prepare($desactivacion1);
        $stmt1->bind_param("i", $id);
    
        if (!$stmt1->execute()) {
            return ["acceso" => false, "mensaje" => "Error al ejecutar la consulta para desactivar usuario en la tabla 'usuarios': " . $stmt1->error];
        }  
        $desactivacion2 = "UPDATE credenciales SET activo = 0 WHERE id = ?";
        $stmt2 = $conexion->prepare($desactivacion2);
        $stmt2->bind_param("i", $id);
    
        if (!$stmt2->execute()) {
            return ["acceso" => false, "mensaje" => "Error al ejecutar la consulta para desactivar credenciales en la tabla 'credenciales': " . $stmt2->error];
        }   
        return ["acceso" => true, "mensaje" => "Desactivado correctamente"];
    }   

    static public function DesactivarProducto($conexion,$id){
        if($id=== null){
            return["status"=>false,"message"=>"Informacion no proporcionada"];
        }
        $sql = "UPDATE productos SET activo = 0 WHERE idProducto = ?";
        $bin = $conexion->prepare($sql);
        $bin->bind_param("s",$id);

        if ($bin->execute()) {
            return["status"=>true,"message"=>"Producto desactivado"];
        }else{
            return["status"=>false,"message"=>"Error al desactivar producto"];
        }
    }

    static public function DesactivarProveedor($conexion,$id){
        if($id === null){
            return["status"=>false,"message"=>"Informacion no proporcionada"];
        }else{
            $sql = "UPDATE proveedores SET estado = 'NO' WHERE idProveedor = ?";
            $bin = $conexion->prepare($sql);
            $bin->bind_param("s",$id);

            if ($bin->execute()){
                return["status"=>true,"message"=>"Desactivado correctamente"];
            }else{
                return["status"=>false,"message"=>"Error al desactivar: $conexion->error"];             
            }
        }
    }
}

?>
