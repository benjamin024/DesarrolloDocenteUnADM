<?php
    $conexion = new mysqli("localhost", "root", "", "unadm")
        or die("No se pudo establecer la conexión con MySQL");

    $conexion->set_charset("utf-8");

    $conexion->query("SET NAMES 'utf8'");
    
    function query($query){
        GLOBAL $conexion;
        return $conexion->query($query);
    }

?>
