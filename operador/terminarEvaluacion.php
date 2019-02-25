<?php
    require("../clases/evaluacion.php");
    $e = new evaluacion;

    $idEvaluacion =@ $_POST["idEvaluacion"];
    $observaciones = array();
    $comentarios =@ $_POST["comentarios"];
    $infoEval = query("SELECT evaluacion, docente, periodo FROM evaluacionDocente WHERE idEvaluacionDocente = $idEvaluacion")->fetch_assoc();
    $evaluacion =  $infoEval["evaluacion"];
    $docente = $infoEval["docente"];
    $periodo = $infoEval["periodo"];
    
    $listObs = $e->getObservaciones();
    foreach($listObs as $lo){
        $obsForm =@$_POST["obs_".$lo["idObservacion"]];
        if($obsForm)
            $observaciones[] = $lo["idObservacion"];
    }

    $criterios = $e->getCriterios($evaluacion);

    $calificacionFinal = 0;    
    foreach($criterios as $criterio){
        $indicadores = $e->getIndicadores($criterio["idCriterio"]);
        $numIndicadores = 0;
        $sumCalif = 0;
        foreach($indicadores as $indicador){
            $calificacion = $e->getCalificacionIndicador($idEvaluacion, $indicador["idIndicador"]);
            //echo "Criterio ".$criterio["idCriterio"]." - Indicador ".$indicador["idIndicador"]." - $calificacion<br>";
            $numIndicadores++;
            $sumCalif += $calificacion;
        }
        $promedioCriterio = $sumCalif / $numIndicadores;
        //echo "Calificación del criterio: $promedioCriterio<br>";
        $e->calificaCriterio($idEvaluacion, $criterio["idCriterio"], $promedioCriterio);
        $calificacionFinal += $promedioCriterio * $criterio["porcentaje"] / 100;
    }
    //echo "Calificación final = $calificacionFinal";
    $e->registraCalificacionFinal($idEvaluacion, $calificacionFinal, $observaciones, $comentarios);
    header("location: resumenEvaluacion.php?evaluacion=$idEvaluacion");
?>