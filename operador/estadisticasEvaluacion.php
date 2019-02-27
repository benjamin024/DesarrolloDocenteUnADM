<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    require("../clases/evaluacion.php");
    require("../clases/periodo.php");
    require("../clases/estadistica.php");
    $e = new evaluacion();
    $p = new periodo();
    $es = new estadistica();
    $evaluaciones = $e->getListaEvaluaciones();
    $periodos = $p->getPeriodos();

    $evaluacion =@$_GET["evaluacion"];
    $periodo =@$_GET["periodo"];

    if($evaluacion && $periodo){
        $criterios = $e->getCriterios($evaluacion);

        $promediosCrit = $es->getPromediosEvaluacion($evaluacion, $periodo);
        $prom_criterios = array();
        $prom_promedios = array();
        foreach($promediosCrit as $pc){
            $prom_criterios[] = "{\"label\":\"".$pc["nombre"]."\"}";
            $prom_promedios[] = "{\"value\":\"".$pc["calPromedio"]."\"}";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Estadísticas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <link rel="stylesheet" href="../css/docentes.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
            $("#modal-title").html("Promedios generales de la evaluación");
            $('#modalGrafica').modal('toggle');
            $("#chart").insertFusionCharts({
            type: 'radar',
            width: '90%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "showBorder": false,
                    "bgColor": "#FFFFFF",
                    "yAxisMaxValue": 10,
                    "dataFillColor": "#FF0000"
                },
                "categories": [{
                    "category": [<?=implode(",", $prom_criterios)?>]
                }],
                "dataset": [{
                    "color": "9D2449",
                    "data": [<?=implode(",", $prom_promedios)?>]
                }]
            }
            });
        }


        function addBotonGraficaGeneral(){
            let boton = "<button class='btn btn-success' onclick='verGrafica();'>Ver gráfica general</button><br><br>"
            document.getElementById("latmenu").innerHTML += boton;
        }


        function muestraLista(){
            $(document).ready(function(){{$('#modalLista').modal('toggle')}});
        }

        function irAEvaluacion(folio){
            $.post("../clases/ajax.php", {ACCION: "getIdEvaluacionDocente", docente: folio, evaluacion: <?=$evaluacion?>, periodo: '<?=$periodo?>'}, function(result){
                    window.location = "resumenEvaluacion.php?evaluacion="+result;
                });
        }

        google.charts.load('current', {packages: ['corechart']});

        function drawChart(data, criterio) {
            var arreglo = [];
            data.split("--").forEach(function(element) {
              arreglo.push(element);
            });
            $("#modal-title").html(criterio);
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Indicador');
            data.addColumn('number', 'Calificación');
            for (var i = 0; i < arreglo.length; i++) {
                data.addRow([arreglo[i].split(",")[0], Math.round(arreglo[i].split(",")[1] * 100) / 100]);
            }

            // Set chart options
            var options = {
            width: 795,
            height: 400,
            legend: { position: "none" },
            bar: {groupWidth: 40},
            colors: ['#9D2449'],
            hAxis: {ticks: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]}
            };

            // Instantiate and draw our chart, passing in some options.          
            var chart = new google.visualization.BarChart(document.getElementById('chart'));
            chart.draw(data, options);
          
        }
    </script>
</head>
<body style="overflow: hidden;">
    <div class="container-fluid" style="padding: 0px !important;">
        <div class="row" style="background-color: #FFF; position: absolute; width: 100%; height: 100px; margin: 0px; ">
            <img src="../img/sep.png" style="max-height: 60px; position: absolute; top: 5px; left: 100px;">
            <img src="../img/unadm.png" style="max-height: 60px; position: absolute; top: 5px; right: 100px;">
        </div>
        <?php
            include("../navbar.html");
        ?>
        <div class="row aguila"  style="position: absolute; top: 0px; padding-top: 126px; width: 100%; z-index: -1; height:100%; margin: 0px;  justify-content: center;">
            <div class="col-md-2 align-items-center" style="">
                <br>
                <center id='latmenu'>
                    <a href="evaluaciones.php"><button class="btn btn-danger">Regresar</button></a><br><br>
                    
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="overflow-y: auto; height: 100%;">
                <br>
                <center>
                    <h3 id="titulo">Estadísticas sobre evaluaciones</h3><br>
                    <div class="col-md-8" style="padding: 0 !important;">
                    <form action="estadisticasEvaluacion.php" method="get">
                        <div class="input-group ">
                            <select class="form-control" name="evaluacion">
                              <option value="0" disabled selected>Selecciona una evaluación</option>
                              <?php
                                foreach($evaluaciones as $e){
                                    $selected = ($evaluacion == $e["idEvaluacion"])?"selected":"";
                                    echo "<option value='".$e["idEvaluacion"]."' $selected>".$e["nombre"]."</option>";
                                }
                              ?>
                            </select>
                            <select class="form-control" name="periodo">
                              <option value="0" disabled selected>Selecciona un periodo</option>
                              <?php
                                foreach($periodos as $p){
                                    $selected = ($periodo == $p["periodo"])?"selected":"";
                                    echo "<option value='".$p["periodo"]."' $selected>".$p["periodo"]."</option>";
                                }
                              ?>
                            </select>
                            <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                        </div> 
                    </form>
                    </div>
                    <?php
                        if(!$evaluacion || !$periodo)
                            echo "<br><h5>Selecciona una evaluación y un periodo para ver sus estadísticas</h5>";
                        else{
                            $docentes = $es->getDocentesEvaluacion($evaluacion, $periodo);
                            if(count($docentes))
                                echo "<script>addBotonGraficaGeneral();</script>";
                    ?> 
                        <br>
                        <div class="col-md-5 btn-danger" style="cursor: pointer; border-radius: 5px;" <?php if(count($docentes) > 0){?>onclick="muestraLista();"<?php }?>><b><?=count($docentes)?></b> docentes han sido evaluados</div>
                        <div class="col-md-10 row" style="margin-top: 35px;">
                    <?php
                            if(count($docentes) > 0){
                                foreach($criterios as $c){
                                    $promedios = implode("--",$es->getPromediosCriterio($c["idCriterio"], $evaluacion, $periodo));
                    ?>
                            <div class="col-md-4" style="margin-bottom: 30px;" onclick="$('#modalGrafica').modal('toggle'); setTimeout(function(){drawChart('<?=$promedios?>', '<?=$c["nombre"]?>');}, 150);">
                                <div id="bloque" class="row h-100" style="position: relative; width: 100%; height: 130px; cursor: pointer; border-radius: 10px; padding: 10px; background-color: #B38E5D">
                                    <h6 id="bloque-texto" style="margin: auto; color: #FFF;"><?=$c['nombre']?></h6>
                                </div>
                            </div>
                    <?php
                                }
                            }
                    ?>
                        
                        </div>
                    <?php
                        }
                    ?>
                </center>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="modalLista">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Docentes evaluados</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body row">
                    <div class="col-md-12 list-group" style="padding: 0px;">
                        <?php
                            if(count($docentes) > 0){
                                for($i = 0; $i < count($docentes); $i++){
                        ?>
                                    <span style="cursor: pointer;" id="d<?=$i?>" onClick="irAEvaluacion('<?=$docentes[$i]["folio"]?>')" class="list-group-item list-group-item-action flex-column align-items-start docente">
                                        <div class="d-flex w-100">
                                            <?php
                                            if($docentes[$i]["img"]){
                                            ?>
                                                <img src="../img/docentes/<?=$docentes[$i]["folio"]?>.jpg" class="rounded-circle" style="max-width: 40px; max-height: 40px;">&nbsp;&nbsp;&nbsp;
                                            <?php
                                            }else{
                                            ?>
                                                <img src="../img/defaultprofile.jpg" class="rounded-circle" style="max-width: 40px; max-height: 40px;">&nbsp;&nbsp;&nbsp;
                                            <?php
                                            }
                                            ?>
                                            <?=$docentes[$i]["apPaterno"]." ".$docentes[$i]["apMaterno"]." ".$docentes[$i]["nombres"]?>
                                        </div>
                                        </span>
                                <?php
                                }
                            }
                                ?>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modalGrafica">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" >

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body row" style="padding: 0px;">
                    <div id="chart" style="padding-left: 15px;"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>