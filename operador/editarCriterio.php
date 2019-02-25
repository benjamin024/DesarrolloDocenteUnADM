<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();

    $id =@$_POST["inputId"];
    $criterio =@$_POST["inputCriterio"];
    $porcentaje =@$_POST["inputPorcentaje"];
    $idE =@$_POST["idEvaluacion"];
    $nombreE =@$_POST["nombre"];
    $porcentajeE =@$_POST["porcentaje"];

    $e->updateCriterio($id, $criterio, $porcentaje);

    header("location: form_editarEvaluacion.php?idEvaluacion=$idE&nombre=$nombreE&porcentaje=$porcentajeE");
?>