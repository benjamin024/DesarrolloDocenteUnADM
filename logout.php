<?php
    session_start();
    

    include_once("clases/usuario.php");
    $u = new usuario();
    $u->destruirCookies($_SESSION["usuario_UnADM"]);
    
    $_SESSION = array();
    session_destroy();

    header("location: index.php");

?>