<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    require("../clases/evaluacion.php");
    $e = new evaluacion;
    $indicadores = explode("--", $_POST["indicadores"]);
    $idEvaluacion = $_POST["idEvaluacion"];
    $regreso = array();
    foreach($indicadores as $indicador){
        if($indicador){
            $calificacion =@$_POST["cal_".$indicador];
            if($calificacion){
                $regreso = $e->registraCalificacion($idEvaluacion, $indicador, $calificacion);
            }
        }
    }
    $url = "form_evaluacion.php?docente=".$regreso["docente"]."&evaluacion=".$regreso["evaluacion"]."&evalPeriodo=".$regreso["periodo"];
    header("location: $url");
?>