<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
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

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporte de resultados de la evaluación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script type='text/javascript'>

    </script>
</head>
<body>
    <div class="container-fluid" style="padding: 0px !important;">
        <div class="row" style="background-color: #FFF; position: absolute; width: 100%; height: 100px; margin: 0px; ">
            <img src="../img/sep.png" style="max-height: 60px; position: absolute; top: 5px; left: 100px;">
            <img src="../img/unadm.png" style="max-height: 60px; position: absolute; top: 5px; right: 100px;">
        </div>
        <?php
            if($_SESSION["tipo"] == 0){
                include("../navbar.html");
                $folder = "";
            }
            else{
                $folder = "../asesor/";
                include("../navbar-a.html");
            }
        ?>
        <div class="row aguila"  style="position: absolute; top: 0px; padding-top: 126px; width: 100%; z-index: -1; height:100%; margin: 0px;  justify-content: center;">
            <div class="col-md-2 align-items-center" style="">
                <br>
                <center id='latmenu'>
                    <a href="calificacionesProfesor.php?folio=<?=$folio?>" class="boton"><button class="btn btn-success">Regresar</button></a><hr>
                    <button class="btn btn-success" onclick="verGrafica();">Ver gráfico</button>
                    <br><br><a href="resumenEvaluacionPDF.php?evaluacion=<?=$idEvaluacionDocente?>" target="_blank" class="boton" id="btnResumen" hidden><button class="btn btn-success">Resumen en PDF</button></a>
                    <?php
                        if($_SESSION["tipo"] == 2){
                    ?>
                    <hr>
                    <a href="../asesor/evaluarDocente.php?evaluacion=<?=$evaluacionBD['idEvaluacion']?>&periodo=<?=$periodo?>" class="boton"><button class="btn btn-danger">Continuar evaluando</button></a>
                    <?php
                    }
                    ?>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; height: 100%; overflow-y: auto;">
                <center>
                    <br><h4>Reporte de resultados de la evaluación</h4><br>                    
                </center>
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td rowspan="3" width="15%" style="padding: 0px;" class="align-middle">
                            <?php
                            if($docente["img"]){
                            ?>
                                <img src="../img/docentes/<?=$docente["folio"]?>.jpg" width="100%" height="auto"><br>
                            <?php
                            }else{
                            ?>
                                <img src="../img/defaultprofile.jpg" width="100%">
                            <?php
                            }
                            ?>
                            </td>
                            <td class="bg-successM" style="color: #FFF; font-weight: bold; text-align: right;">
                                Folio: 
                            </td>
                            <td>
                                <?=$docente["folio"]?>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: right;">Nombre: </td>
                            <td><?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></td>
                        </tr>
                        <tr>
                            <td  width="15%" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: right;">CURP:</td>
                            <td><?=$docente["curp"]?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <td width="30%" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: right;">Evaluación:</td>
                        <td><?=$evaluacionBD["nombre"]?></td>
                    </tr>
                    <tr>
                        <td width="30%" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: right;">Periodo</td>
                        <td><?=$periodo?></td>
                    </tr>
                </table>
                <?php
                    $dataIndicadores = array();
                    $dataCalificaciones = array();

                            $dataIndicadoresG = array();
                            $dataCalificacionesG = array();

                    $criterios = $e->getCriterios($evaluacionBD["idEvaluacion"]);
                    foreach($criterios as $criterio){
                        $indicadores = $e->getIndicadores($criterio["idCriterio"]);
                ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: center;"><?=$criterio["nombre"]?></td>
                            </tr>
                            <tr>
                                <td width="80%" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: center;">Indicador</td>
                                <td witdh="20%" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: center;">Calificación</td>
                            </tr>
                            <?php

                            foreach($indicadores as $indicador){
                                if($indicador["titulo"]){
                                    $auxString = "{\"label\":\"".$indicador["titulo"]." (".$criterio["nombre"].")\"}";
                                    $dataIndicadoresG[] = $indicador["titulo"]." (".$criterio["nombre"].")";
                                }
                                else{
                                    $auxString = "{\"label\":\"".$criterio["nombre"]."\"}";
                                    $dataIndicadoresG[] = $criterio["nombre"];
                                }
                                $dataIndicadores[] = $auxString;
                                $calificacion = query("SELECT calificacion FROM indicadorCalificacion WHERE idEvaluacion = $idEvaluacionDocente AND indicador = ".$indicador["idIndicador"])->fetch_assoc()["calificacion"];
                                $dataCalificaciones[] = "{\"value\":\"$calificacion\"}";
                                $dataCalificacionesG[] = $calificacion;
                                $evaluacion = query("SELECT texto FROM escalaEvaluacion WHERE puntos = $calificacion")->fetch_assoc()["texto"];
                                $msjEvaluacion = query("SELECT texto FROM indicadorEscala WHERE escala = $calificacion AND idIndicador = ".$indicador["idIndicador"])->fetch_assoc()["texto"];
                                if($indicador["titulo"]){
                                    $ind = "<b>".$indicador["titulo"].":</b><br>".nl2br($indicador["mensaje"]);
                                }else{
                                    $ind = nl2br($indicador["mensaje"]);
                                }
                                echo "<td>$ind</td>";
                                echo "<td><b>$evaluacion, $calificacion puntos</b><br>$msjEvaluacion</td></tr>";
                            }
                            ?>
                            <tr>
                                <td class="bg-successM" style="color: #FFF; font-weight: bold; text-align: right;">Calificación promedio del criterio:</td>
                                <td class="bg-successM" style="color: #FFF; font-weight: bold; text-align: center;"><?=round(query("SELECT calificacion FROM criterioCalificacion WHERE idEvaluacion = $idEvaluacionDocente AND criterio = ".$criterio["idCriterio"])->fetch_assoc()["calificacion"] * 100) / 100?></td>
                            </tr>
                        </table>
                <?php
                    }
                ?>

                <table class="table table-bordered">
                    <tr>
                        <td class="bg-successM" style="color: #FFF; font-weight: bold; text-align: center;">Observaciones generales</td>
                    </tr>
                    <tr>
                        <td>
                        <?php
                            if(!$observaciones)
                                echo "<center>Sin observaciones</center>";
                            else{
                                echo "<ul>";
                                foreach($observaciones as $observacion){
                                    echo "<li>$observacion</li>";
                                }
                                echo "</ul>";
                            }
                        ?>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <td class="bg-successM" style="color: #FFF; font-weight: bold; text-align: center;">Comentarios</td>
                    </tr>
                    <tr>
                        <td><?=$comentarios?></td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <td width="80%" class="bg-successM" style="color: #FFF; font-weight: bold; text-align: right;">CALIFICACIÓN FINAL:</td>
                        <td class="bg-successM" style="color: #FFF; font-weight: bold; text-align: center;"><?=round($calificacionFinal * 100) / 100?></td>
                    </tr>
                </table><br><br>
                
            </div>
        </div>
        <div id="graficaEvaluacion" style="width: 795; height: 400;"></div>
        <div class="modal fade" id="modalGrafica">
            <div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5><?=$evaluacionBD["nombre"]." de ".$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]." ($periodo)"?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="radar-chart"></div>
                </div>

                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- FusionCharts files-->
	<script type="text/javascript" src="../js/fusioncharts.js"></script>
	<script type="text/javascript" src="../js/fusioncharts.charts.js"></script>
	<script type="text/javascript" src="../js/powercharts.js"></script>

	<!-- jQuery plugin -->
	<script type="text/javascript" src="../js/jquery-plugin.js"></script>
	<script>
		function verGrafica(){
            $('#modalGrafica').modal('toggle');
            $("#radar-chart").insertFusionCharts({
            type: 'radar',
            width: '100%',
            height: '500',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "showBorder": false,
                    "bgColor": "#FFFFFF",
                    "yAxisMaxValue": 10,
                    "dataFillColor": "#FF0000"
                },
                "categories": [{
                    "category": [<?=implode(",", $dataIndicadores)?>]
                }],
                "dataset": [{
                    "color": "9D2449",
                    "data": [<?=implode(",", $dataCalificaciones)?>]
                }]
            }
            });
		}

        // Load the Visualization API and the piechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(graficaEvaluacion);
        
        function graficaEvaluacion(){
            // Create our data table.
            data = new google.visualization.DataTable();

            data.addColumn('string', 'Criterio');
            data.addColumn('number', 'Calificación');
            <?php
                for($i = 0; $i < count($dataIndicadoresG); $i++){
            ?>
                data.addRow(["<?=$dataIndicadoresG[$i]?>", Math.round(<?=$dataCalificacionesG[$i]?> * 100) / 100]);
            <?php
                }
            ?>

            // Set chart options
            var options = {
            width: 795,
            height: 400,
            title: 'Gráfica de calificaciones obtenidas por indicador',
            chartArea: {top: 10, left: 180},
            legend: { position: "none" },
            colors: ['#9D2449'],
            hAxis: {ticks: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]}
            };
    
            // Instantiate and draw our chart, passing in some options.
            var graficaEvaluacion = document.getElementById('graficaEvaluacion');
            chart = new google.visualization.ColumnChart(graficaEvaluacion);
            google.visualization.events.addListener(chart, 'ready', function(){
                console.log(chart.getImageURI());
                graficaEvaluacion.innerHTML = "<img src='" + chart.getImageURI()+"'>";
                $.post("../clases/ajax.php", {ACCION: "guardarImagen", imagen: chart.getImageURI(), nombre: "evaluacion_<?=$idEvaluacionDocente?>", url: "../img/graficas_evaluaciones/"}, 
                    function(result){
                        if(result == 1){
                            $("#graficaEvaluacion").attr("hidden", true);
                            $("#btnResumen").attr("hidden", false);
                        }
                    }
                );
            });
            chart.draw(data, options);
        }
	</script>
</body>
</html>