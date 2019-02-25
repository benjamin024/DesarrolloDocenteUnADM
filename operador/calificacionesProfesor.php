<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    require("../clases/docente.php");
    $folio =@$_GET["folio"];
    $e = new evaluacion();
    $d = new docente();
    $evaluaciones = $e->getListaEvaluaciones();
    $docente = $d->getDocente($folio);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Calificaciones de <?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></title>
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
                    <a href="<?=$folder?>fichaProfesor.php?folio=<?=$folio?>" class="boton"><button class="btn btn-success">Regresar</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%;">
                <center>
                    <br><h4>Calificaciones de <?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></h4><br>                    
                </center>
                <?php
                    $calificaciones = $e->getCalificacionesDocente($folio);
                    if($calificaciones){
                ?>
                <table class="table table-bordered table-sm table-responsive">
                    <thead class="bg-successM" style="text-align: center;">
                        <tr>
                            <th rowspan="2" class="align-middle">Periodo</th>
                            <th colspan="<?=count($evaluaciones)?>" class="align-middle">Evaluaciones</th>
                            <th rowspan="2" class="align-middle">Calificación final</th>
                        </tr>
                        <tr>
                            <?php
                                foreach($evaluaciones as $evaluacion){
                                    echo "<th class='align-middle'>".$evaluacion["nombre"]." (".$evaluacion["porcentaje"]."%)</th>";
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;" >
                        <?php
                            foreach($calificaciones as $calificacion){
                        ?>
                        <tr>
                            <td class="align-middle"><?=$calificacion["periodo"]?></td>
                            <?php
                            foreach($evaluaciones as $evaluacion){
                                if(is_numeric($calificacion["evaluacion_".$evaluacion["idEvaluacion"]]))
                                    echo "<td class='align-middle'><a href='resumenEvaluacion.php?evaluacion=".$calificacion["idEvaluacion"]."'>".(round($calificacion["evaluacion_".$evaluacion["idEvaluacion"]] * 100) / 100)."</a></td>";
                                else
                                    echo "<td class='align-middle'>".$calificacion["evaluacion_".$evaluacion["idEvaluacion"]]."</td>";
                            }
                            ?>
                            <td class="align-middle"><?=round($calificacion["calificacionFinal"] * 100) / 100?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }else{
                        echo "<center><h5>No hay calificaciones registradas para este docente</h5></center>";
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>