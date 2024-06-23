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
        $sql = "SELECT * FROM administradores WHERE id = :id AND token = :token";
        $bin = $conexion->prepare($sql);
        $bin->bindParam(":id", $this->id);
        $bin->bindParam(":token",$this->token);
        $bin->execute();
        $result = $bin->fetch(PDO::FETCH_ASSOC);
    
        if ($result !== null) {
            $row = $result;
            return json_encode($row); 
        } else {
            return false;
        }
    }
    

    public static function Registro($conexion,$username, $email, $password){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(16));
        $id_admin = substr(uniqid(), 0, 10);
        $sql = "INSERT INTO administradores VALUES (:id,:username,:email,:token,:password,1)";
        $bin = $conexion->prepare($sql);
        $bin->bindParam(":id",$id_admin);
        $bin->bindParam(":username",$username);
        $bin->bindParam(":email",$email);
        $bin->bindParam(":token",$token);
        $bin->bindParam(":password",$hashedPassword);

        if($bin->execute()){
            return true;
        }else{
            return false;
            
        }

    }
    public function LogIn($correo, $contraseña){
        global $conexion;
        $query = "SELECT * FROM administradores WHERE email= :email AND activo=1";
        $statement = $conexion->prepare($query);
        $statement->bindParam(":email", $correo);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($result !== false) {
            if (count($result) > 0) {
                $row = $result[0];
                $hashedPassword = $row['clave'];
                if (password_verify($contraseña, $hashedPassword)) {
                    return [
                        "status" => true,
                        "mensaje" => "Verificado correctamente",
                        'usuario' => [
                            "id_admin" => $row['id'],
                            "username" => $row['username'],
                            "token" => $row['token'],
                            "email" => $row['email']
                        ]
                    ];
                } else {
                    return ["status" => false, "mensaje" => "Contraseña incorrecta"];
                }
            } else {
                return ["status" => false, "mensaje" => "Usuario no encontrado"];
            }
        } else {
            return ["status" => false, "mensaje" => 'Error en la consulta: ' . $conexion->error];
        }
    }
    
    
    public function AgregarMarca($nombre) {
        global $conexion;
        $sql = "INSERT INTO marcas (marca) VALUES (?)";
    
        return $conexion->prepare($sql)->execute([$nombre]);
    }
    public function DesactivarUsuario($conexion, $id) {
        if ($id === null) {
            return ["status" => false, "mensaje" => "No se proporcionó un ID"];
        } 
    
        $desactivacion1 = "UPDATE usuarios SET activo = 0 WHERE id = :id";
        $stmt1 = $conexion->prepare($desactivacion1);
        $stmt1->bindParam(":id", $id, PDO::PARAM_INT);
        
        if (!$stmt1->execute()) {
            return ["status" => false, "mensaje" => "Error al ejecutar la consulta para desactivar usuario en la tabla 'usuarios': " . $stmt1->errorInfo()[2]];
        }  
    
        $desactivacion2 = "UPDATE credenciales SET activo = 0 WHERE id = :id";
        $stmt2 = $conexion->prepare($desactivacion2);
        $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
        
        if (!$stmt2->execute()) {
            return ["status" => false, "mensaje" => "Error al ejecutar la consulta para desactivar credenciales en la tabla 'credenciales': " . $stmt2->errorInfo()[2]];
        }   
    
        return ["status" => true, "mensaje" => "Desactivado correctamente"];
    }  
    

    static public function DesactivarProducto($conexion, $id,$token) {
        if ($id === null) {
            return ["status" => false, "message" => "Información no proporcionada"];
        }
        if ($token === null){
            return ["status" => false, "message" => "Información no proporcionada"];
        }
        $sqlVerifyToken = "SELECT*FROM administradores WHERE token = :token";
        $stmtVerifyToken = $conexion->prepare($sqlVerifyToken);
        $stmtVerifyToken->bindParam(":token",$token);
        if($stmtVerifyToken == null){
            return ["status" => false, "message" => "Token incorrecto"];
        }    
    
        $sql = "UPDATE productos SET activo = 0 WHERE idProducto = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return ["status" => true, "message" => "Producto desactivado"];
        } else {
            return ["status" => false, "message" => "Error al desactivar producto"];
        }
    }
    static public function DesactivarProveedor($conexion, $id) {
        if ($id === null) {
            return ["status" => false, "message" => "Información no proporcionada"];
        } else {
            $sql = "UPDATE proveedores SET estado = false WHERE idProveedor = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(":id", $id);
    
            if ($stmt->execute()) {
                return ["status" => true, "message" => "Desactivado correctamente"];
            } else {
                return ["status" => false, "message" => "Error al desactivar: " . $conexion->errorInfo()[2]];
            }
        }
    }
    
}

?>
