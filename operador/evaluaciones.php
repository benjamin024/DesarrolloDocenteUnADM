<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();
    $evaluaciones = $e->getListaEvaluaciones();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Evaluaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">

    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <style>
        .link{
            color: #000;
            text-decoration: none;
        }
        .link:visited{
            color: #000;
            text-decoration: none;
        }
        .link:hover{
            color: #000;
            text-decoration: none;
        }
        .link:active{
            color: #000;
            text-decoration: none !active;
        }
    </style>
    <script>
        google.charts.load('current', {packages: ['corechart']});

        function drawChart(data, evaluacion) {
            var arreglo = [];
            data.split("--").forEach(function(element) {
              arreglo.push(element);
            });
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Indicador');
            data.addColumn('number', 'Calificación');
            for (var i = 0; i < arreglo.length; i++) {
                data.addRow([arreglo[i].split(",")[0], Math.round(arreglo[i].split(",")[1] * 100) / 100]);
            }

            // Set chart options
            var options = {
            title: evaluacion,
            width: 800,
            height: 400,
            chartArea:{top: '12.5%', width:'80%',height:'75%'}
            };

            // Instantiate and draw our chart, passing in some options.          
            var chart = new google.visualization.PieChart(document.getElementById('chart'));

            google.visualization.events.addListener(chart, 'ready', function(){
                console.log(chart.getImageURI());
                document.getElementById('chart').innerHTML = "<img src='" + chart.getImageURI()+"'>";
                /*
                $.post("../clases/ajax.php", {ACCION: "guardarImagen", imagen: chart.getImageURI(), nombre: "evaluacion_<?=$idEvaluacionDocente?>", url: "../img/graficas_evaluaciones/"}, 
                    function(result){
                        if(result == 1){
                            $("#btnResumen").attr("hidden", false);
                        }
                    }
                );*/
            });

            chart.draw(data, options);
          
        }
    </script>
</head>
<body>
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
                    <a href="#" class="boton"><button class="btn btn-danger">Registrar nueva</button></a><br><br>
                    <a href="estadisticasEvaluacion.php" class="boton"><button class="btn btn-success">Estadísticas</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; height: 100%; overflow-y: auto;">
                <center>
                    <br><h4>Evaluaciones</h4><br>                    
                </center>
                <div id="chart"></div>
                <div class="row">
                        <div id="accordion" style="width: 100%;">
                            <?php
                                foreach($evaluaciones as $evaluacion){

									$datosGrafica = array();
                            ?>
                                    <div class="card">
                                        <div class="card-header bg-successM" id="evaluacion<?=$evaluacion['idEvaluacion']?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?=$evaluacion['idEvaluacion']?>" aria-expanded="true" aria-controls="collapse<?=$evaluacion['idEvaluacion']?>" style="color: #FFF;">
                                            <?=$evaluacion["nombre"]." (".$evaluacion["porcentaje"]."%)"?>
                                            </button>
                                        </h5>
                                        </div>

                                        <div id="collapse<?=$evaluacion['idEvaluacion']?>" class="collapse" aria-labelledby="evaluacion<?=$evaluacion['idEvaluacion']?>" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                <?php
                                                    $criterios = $e->getCriterios($evaluacion["idEvaluacion"]);
                                                    foreach($criterios as $criterio){
                                                        echo "<a href='criterio.php?id=".$criterio["idCriterio"]."&criterio=".$criterio["nombre"]."&evaluacion=".$evaluacion["nombre"]."'  class='list-group-item link'>".$criterio["nombre"]." (".$criterio["porcentaje"]."%)</a>";
                                                        $datosGrafica[] = $criterio["nombre"].",".$criterio["porcentaje"];
                                                    }
                                                    $datosGrafica = implode("--", $datosGrafica);
                                                    echo $datosGrafica;
                                                ?>
                                                <div class="" style="padding-top: 1em; text-align: right;">
                                                    <a href="form_editarEvaluacion.php?idEvaluacion=<?=$evaluacion['idEvaluacion']?>&nombre=<?=$evaluacion["nombre"]?>&porcentaje=<?=$evaluacion["porcentaje"]?>"><button class="btn btn-success">Editar evaluación</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                    </div>
                </div>
                
                <!---->
            </div>
        </div>
    </div>
    
    <script src="../js/bootstrap.min.js"></script>

</body>
</html>