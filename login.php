<?php
    session_start();
    $user =@ $_POST["usuario"];
    $pass =@ $_POST["pass"];
    $recuerda =@ $_POST["recuerda"];

    include_once("clases/usuario.php");

    $u = new usuario();

    $resultado = $u->getUsuarioLogin($user, $pass);
    if($resultado){
        if(count($resultado) > 0){
            if($recuerda == 1){
                $u->crearCookies($user);
                echo $_COOKIE["usuario_UnADM"]."<br>".$_COOKIE["clave_UnADM"];
                //print_r($_COOKIE);
            }
            $_SESSION["usuario_UnADM"] = $user;
            $_SESSION["tipo"] = 0;
            header("location: operador/docentes.php");
        }
    }else{
        $resultado = $u->getDocenteLogin($user, $pass);
        if($resultado){
            if(count($resultado) > 0){
                $_SESSION["usuario_UnADM"] = $user;
                $_SESSION["tipo"] = 1;
                header("location: docente/index.php");
            }
        }else{
            $resultado = $u->getAsesorLogin($user, $pass);
            if($resultado){
                if(count($resultado) > 0){
                    $_SESSION["usuario_UnADM"] = $user;
                    $_SESSION["tipo"] = 2;
                    header("location: asesor/index.php");
                }
            }else{
                header("location: index.php?error=1");
            }
        }
    }


?>