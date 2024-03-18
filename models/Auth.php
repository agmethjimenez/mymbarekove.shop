<?php
class Auth {
    private $claveget;

    public function setToken($token){
        $this->claveget = $token;
    }

    public function verificarToken($token) {
        $token = str_replace("Bearer ", "", $token);

        if ($token == $this->claveget) {
            return true;
        } else {
            return false;
        }
    }

    
}
?>
