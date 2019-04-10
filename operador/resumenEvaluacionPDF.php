<?php
    use Dompdf\Dompdf;
    require_once("../dompdf/autoload.inc.php");
    
    require("../clases/evaluacion.php");
    require("../clases/docente.php");

    $idEvaluacionDocente =@$_GET["evaluacion"];

    $e = new evaluacion();
    $d = new docente();

    $infoED = query("SELECT * FROM evaluacionDocente WHERE idEvaluacionDocente = $idEvaluacionDocente")->fetch_assoc();
    $folio = $infoED["docente"];
    $docente = $d->getDocente($folio);
    $evaluacionBD = query("SELECT * FROM evaluacion WHERE idEvaluacion = (SELECT evaluacion FROM evaluacionDocente WHERE idEvaluacionDocente = $idEvaluacionDocente)")->fetch_assoc();
    $periodo = $infoED["periodo"];
    $observaciones = $e->getObservacionesEvaluacion($idEvaluacionDocente);
    $comentarios = $infoED["comentario"];
    $calificacionFinal = $infoED["calificacion"];

    $dompdf = new DOMPDF();
    $html = "<html><head><style>@page {
        margin: 35px 70px;
    }
    table, th, td {
      border: 1px solid #E2E2E2;
      border-collapse: collapse;
    }
    </style>
    <link rel='stylesheet' href='../css/colores_institucionales.css'>
    <link rel='stylesheet' href='../css/docentes.css'>
    </head>";
    $html .= "<body>";
    $html .= "<div><img src='../img/sep.png' height='50px'></div>";
    $html .= "<div style='position: absolute;  top: 0px; right: 0px;'><img src='../img/unadm.png' height='50px'></div>";
    $html .= "<div style='background-color: #621132; margin-top: 20px; height: 25px; width: 100%;'></div>";
    $html .= "<center><br><h2>Resumen de resultados de la ".$evaluacionBD["nombre"]."</h2><br></center>";
    $html .= "<p style='text-align: justify;'>La UnADM realiza la evaluación del desempeño de las funciones sustantivas de los docentes con el objetivo de coadyuvar a la mejora de la práctica educativa y de elevar la calidad del servicio que ofrece a sus estudiantes.</p>";
    $html .= "<p style='text-align: justify;'>La evaluación de desempeño docente es realizada por el asesor académico que tiene asignado el profesor y considera los siguientes aspectos: Planeación didáctica, Comunicación, Uso y  manejo de las herramientas del aula virtual, Actividades didácticas, Retroalimentación y Estrategias de retención y recuperación de estudiantes.</p>";
    $html .= "<p style='text-align: justify;'>Los resultados permiten conocer las áreas de oportunidad que se deben atender, ya que nuestra evaluación tiene un sentido formativo, sumativo y holístico, ello nos permite que después del análisis de resultados, se logre mejorar el nivel de cumplimiento de sus funciones.</p><br><br>";
    $html .= "<h3>Informe de evaluación</h3>";
    $html .= "<img src='../img/escalas_evaluaciones/escala_1.png' width='100%'><br><br>";
    $html .= "<h3>Desgloce de resultados</h3><br>";
    $html .= "<table style='border: solid 0.25px #000;'>
                    <tbody>
                        <tr>
                            <td rowspan='3' width='130px' style='padding: 0px;' class='align-middle'>";
                            if($docente["img"]){
                        
    $html .=                    "<img src='../img/docentes/{$docente['folio']}.jpg' width='130px' height='100%'><br>";
                            }else{
    $html .=                    "<img src='../img/defaultprofile.jpg' width='130px' height='100%'>";
                            }
    $html .=
                            "</td>
                            <td class='bg-successM' width='150px' style='color: #FFF; font-weight: bold; text-align: right; padding-right: 10px;'>
                                Folio: 
                            </td>
                            <td width='385px'>
                                {$docente['folio']}
                            </td>
                        </tr>
                        <tr>
                            <td  width='150px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: right; padding-right: 10px;'>Nombre: </td>
                            <td width='385px'>{$docente['nombres']} {$docente['apPaterno']} {$docente['apMaterno']}</td>
                        </tr>
                        <tr>
                            <td   width='150px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: right; padding-right: 10px;'>CURP:</td>
                            <td width='385px'>{$docente['curp']}</td>
                        </tr>
                    </tbody>
                </table><br>";
    $html .= "<table class='table table-bordered'>
                    <tr>
                        <td width='280px'  height='40px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: right; padding-right: 10px;'>Evaluación:</td>
                        <td width='385px'>".$evaluacionBD['nombre']."</td>
                    </tr>
                    <tr>
                        <td width='280px' height='40px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: right; padding-right: 10px;'>Periodo:</td>
                        <td width='385px'>$periodo</td>
                    </tr>
                </table><br>";

    $criterios = $e->getCriterios($evaluacionBD["idEvaluacion"]);
    foreach($criterios as $criterio){
        $indicadores = $e->getIndicadores($criterio["idCriterio"]);
        $html .= "<table class='table table-bordered'>
                    <tr>
                        <td height='40px' colspan='2' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: center;'>".$criterio['nombre']."</td>
                    </tr>
                    <tr>
                        <td  width='509px' height='20px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: center;'>Indicador</td>
                        <td width='166px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: center;'>Calificación</td>
                    </tr>";
        foreach($indicadores as $indicador){
            $calificacion = query("SELECT calificacion FROM indicadorCalificacion WHERE idEvaluacion = $idEvaluacionDocente AND indicador = ".$indicador["idIndicador"])->fetch_assoc()["calificacion"];
            $evaluacion = query("SELECT texto FROM escalaEvaluacion WHERE puntos = $calificacion")->fetch_assoc()["texto"];
            if($indicador["titulo"]){
                $ind = $indicador["titulo"];
            }else{
                $ind = $criterio['nombre'];
            }
            $html .= "<tr><td>$ind</td>
                      <td style='text-align: center;'>$evaluacion ($calificacion puntos)</td></tr>";
        }
        $html .= "<tr>
                    <td class='' style=' font-weight: bold; text-align: right;'>Calificación promedio del criterio:&nbsp;</td>
                    <td class='' style=' font-weight: bold; text-align: center;'>";
        $calificacionC = round(query("SELECT calificacion FROM criterioCalificacion WHERE idEvaluacion = $idEvaluacionDocente AND criterio = ".$criterio["idCriterio"])->fetch_assoc()["calificacion"] * 100) / 100;
        $html .= "$calificacionC</td></tr>";
        $html .= "</table><br>";
    }
    $html .= "<img width='675px' height='auto' style='margin-top: -5px;' src='../img/graficas_evaluaciones/evaluacion_$idEvaluacionDocente.png'><br>";
    $html .= "<br><table class='table table-bordered'>
                    <tr>
                        <td width='675px' height='40px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: center;'>Observaciones generales</td>
                    </tr>
                    <tr>
                        <td>";
                            if(!$observaciones)
                                $html .= '<center>Sin observaciones</center>';
                            else{
                                $html .= '<ul>';
                                foreach($observaciones as $observacion){
                                    $html .= "<li>$observacion</li>";
                                }
                                $html .= '</ul>';
                            }
                        $html .=
                        "</td>
                    </tr>
                </table><br>
                <table class='table table-bordered'>
                    <tr>
                        <td width='675px' height='40px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: center;'>Comentarios</td>
                    </tr>
                    <tr>
                        <td>$comentarios</td>
                    </tr>
                </table><br>
                <table class='table table-bordered'>
                    <tr>
                        <td width='509px' height='40px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: right;'>CALIFICACIÓN FINAL:&nbsp;</td>
                        <td width='166px' class='bg-successM' style='color: #FFF; font-weight: bold; text-align: center;'>".(round($calificacionFinal * 100) / 100)."</td>
                    </tr>
                </table>";
    $html .= "</body></html>";
    //echo $html;
    //exit(1);
    $dompdf->load_html($html);
	$dompdf->render();
    $dompdf->stream(
        "Resumen de evaluación.pdf",
        array(
            "Attachment" => false
        )
    );
?>