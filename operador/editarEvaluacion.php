<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();

    $id =@$_POST["idEvaluacion"];
    $porcentaje =@$_POST["porcentaje"];
    $nombre =@$_POST["nombre"];

    $e->updateEvaluacion($id, $nombre, $porcentaje);

    header("location: evaluaciones.php");
?>