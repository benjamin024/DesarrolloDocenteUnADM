<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();
    $indicadores = $e->getIndicadores($_GET["id"]);
    $criterio = $_GET["criterio"];
    $evaluacion = $_GET["evaluacion"];
    $escala = $e->getEscalaEvaluacion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$criterio." - ".$evaluacion?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
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
                    <a href="evaluaciones.php" class="boton"><button class="btn btn-danger">Regresar</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%;  overflow-y: auto;">
                <center>
                    <br><h4><?=$criterio." - ".$evaluacion?></h4><br>                    
                </center>
                <table class="table table-bordered table-sm table-responsive">
                    <thead class="bg-successM" style="text-align: center;">
                        <tr>
                            <th rowspan="2" width="50%" class="align-middle">Indicadores</th>
                            <th colspan="<?=count($escala)?>" class="align-middle">Escala de Evaluación</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($escala as $esc){
                                    echo "<th class='align-middle'>".$esc["texto"].", ".$esc["puntos"]." puntos</th>";
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($indicadores as $indicador){
                                echo "<tr>";
                                if($indicador["titulo"]){
                                    $ind = "<b>".$indicador["titulo"].":</b><br>".nl2br($indicador["mensaje"]);
                                }else{
                                    $ind = nl2br($indicador["mensaje"]);
                                }
                                echo "<td>$ind</td>";
                                $escalaEv = $e->getIndicadorEscala($indicador["idIndicador"]);
                                foreach($escalaEv as $eEv){
                                    echo "<td>".$eEv["texto"]."</td>";
                                }
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>