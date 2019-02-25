<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();

    $nombre =@$_POST["inputCriterio"];
    $porcentaje =@$_POST["inputPorcentaje"];
    $idE =@$_POST["idEvaluacion"];
    $nombreE =@$_POST["nombre"];
    $porcentajeE =@$_POST["porcentaje"];

    $e->addCriterio($nombre, $porcentaje, $idE);

    header("location: form_editarEvaluacion.php?idEvaluacion=$idE&nombre=$nombreE&porcentaje=$porcentajeE");
?>