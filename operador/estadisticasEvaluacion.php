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
    <script>
        function muestraLista(){
            $(document).ready(function(){{$('#modalLista').modal('toggle')}});
        }

        function irAEvaluacion(folio){
            $.post("../clases/ajax.php", {ACCION: "getIdEvaluacionDocente", docente: folio, evaluacion: <?=$evaluacion?>, periodo: '<?=$periodo?>'}, function(result){
                    window.location = "resumenEvaluacion.php?evaluacion="+result;
                });
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
            <div class="col-md-10 align-items-center">
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
                    ?> 
                        <br>
                        <div class="col-md-5 btn-danger" style="cursor: pointer; border-radius: 5px;" <?php if(count($docentes) > 0){?>onclick="muestraLista();"<?php }?>><b><?=count($docentes)?></b> docentes han sido evaluados</div>
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
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>