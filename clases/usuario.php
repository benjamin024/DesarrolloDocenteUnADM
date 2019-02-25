<?php
    include_once("database.php");

    class usuario{
        public function getUsuarioLogin($user, $pass){
            $query = "SELECT * FROM usuario WHERE usuario = '$user' AND password = SHA1('$pass');";
            $resultado = query($query);
            $resultado = $resultado->fetch_assoc();
            return $resultado;
        }

        public function getDocenteLogin($folio, $pass){
            $query = "SELECT * FROM docente WHERE folio ='$folio' AND password = SHA1('$pass');";
            $resultado = query($query);
            $resultado = $resultado->fetch_assoc();
            return $resultado;
        }

        public function getAsesorLogin($rfc, $pass){
            $query = "SELECT * FROM asesor WHERE rfc ='$rfc' AND password = SHA1('$pass');";
            $resultado = query($query);
            $resultado = $resultado->fetch_assoc();
            return $resultado;
        }

        public function crearCookies($user){
            $clave = sha1(date("Y-m-d H:i:s"));
            setcookie("usuario_UnADM", $user , time()+(60*60*24*365));
            setcookie("clave_UnADM", $clave , time()+(60*60*24*365));
            query("UPDATE usuario SET cookie = '$clave' WHERE usuario = '$user';");
        }

        public function destruirCookies($user){
            unset($_COOKIE['usuario_UnADM']);
            unset($_COOKIE['clave_UnADM']);
            setcookie('usuario_UnADM', "", time()-1);
            setcookie('clave_UnADM', "", time()-1);
            query("UPDATE usuario SET cookie = '' WHERE usuario = '$user';");
        }

        public function logueadoCookies(){
            $query = "SELECT * FROM usuario WHERE usuario = '".$_COOKIE["usuario_UnADM"]."' AND cookie = '".$_COOKIE["clave_UnADM"]."';";
            $resultado = query($query);
            $resultado = $resultado->fetch_assoc();
            if(count($resultado) > 0)
                return true;
            else
                return false;
        }
        
    }
?>