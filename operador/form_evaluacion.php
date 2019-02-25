<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    require("../clases/evaluacion.php");
    $e = new evaluacion;
    if(!$evaluacion)
        $evaluacion =@$_GET["evaluacion"];
    if(!$docente)
        $docente =@$_GET["docente"];
    if(!$periodo)
        $periodo =@$_GET["evalPeriodo"];

    $nombreEvaluacion = query("SELECT nombre FROM evaluacion WHERE idEvaluacion = $evaluacion")->fetch_assoc()["nombre"];
    $aux = query("SELECT nombres, apPaterno, apMaterno FROM docente WHERE folio = '$docente'")->fetch_assoc();
    $nombreDocente = $aux["nombres"]." ".$aux["apPaterno"]." ".$aux["apMaterno"];

    if(!$evaluacion || !$docente || !$periodo){
        header("location: docentes.php");
    }else{
        //Checar si ya existe idEvaluación para estos 3 parámetros, si no, crearlo
        $qr = "SELECT count(*) AS existe FROM evaluacionDocente WHERE evaluacion = $evaluacion AND docente = '$docente' AND periodo = '$periodo'";
        $existe = query($qr)->fetch_assoc()["existe"];
        if($existe){
            $qr = "SELECT idEvaluacionDocente FROM evaluacionDocente WHERE evaluacion = $evaluacion AND docente = '$docente' AND periodo = '$periodo'";
            $idEvaluacion = query($qr)->fetch_assoc()["idEvaluacionDocente"];
        }else{
            $qr = "INSERT into evaluacionDocente(evaluacion, docente, periodo) VALUES($evaluacion, '$docente', '$periodo');";
            query($qr);
            $idEvaluacion = query("SELECT last_insert_id() AS lii")->fetch_assoc()["lii"];
        }
        $datos = $e->getCriteriosPorcentaje($idEvaluacion);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$nombreEvaluacion." para ".$nombreDocente." (".$periodo.")"?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <script>
        function abreModal(id, nombre){
            document.getElementById("iframeModal").setAttribute("src", "iframe_evaluaCriterio.php?idEvaluacion=<?=$idEvaluacion?>&idCriterio="+id);
            $('#modalTitulo').html("Evaluando " + nombre);
            $('#modalEvaluaCriterio').modal('toggle');
        }

        function limpia(){
            $.post("../clases/ajax.php", {ACCION: "limpiaEvaluacion", evaluacion: <?=$idEvaluacion?>}, function(result){
                if(result == "OK")
                    location.reload();
                else
                    alert("Error");
            });
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
                    <button class="btn btn-danger" onclick="$('#modalLimpiar').modal('toggle')">Limpiar evaluación</button>
                    <hr>
                    <a href="<?=$folder?>fichaProfesor.php?folio=<?=$docente?>" class="boton"><button class="btn btn-danger">Regresar</button></a><br><br>
                    <button class="btn btn-success" onclick="$('#modalEnviar').modal('toggle')">Terminar evaluación</button><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%;">
                <center>
                    <br><h4><?=$nombreEvaluacion." para ".$nombreDocente." (".$periodo.")"?></h4><br>                    
                </center>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            foreach($datos as $d){
                        ?>
                                <div class="progress" style="cursor: pointer; height: 3.5em;" onclick="abreModal(<?=$d['idCriterio']?>, '<?=$d['criterio']?>');">
                                    <div class="progress-bar" role="progressbar" style="color: #000; font-size: 16px; text-align: left; width: <?=$d["porcentaje"]?>%; background-color: #D4C19C !important;" aria-valuenow="<?=$d["porcentaje"]?>" aria-valuemin="0" aria-valuemax="100">&nbsp;&nbsp;&nbsp;&nbsp;<?=$d["criterio"]." (".$d["porcentaje"]."% completado)"?></div>
                                </div>
                                <br>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEvaluaCriterio">
            <div class="modal-dialog modal-lg" style=" max-width: 1200px !important;">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" style="height: 520px;">
                    <iframe id="iframeModal" src="" width="100%" height="100%" frameborder="0"></iframe>
                </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalLimpiar">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Limpiar evaluación</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    ¿Estás seguro que deseas limpiar esta evaluación?<br>
                    Si es así, presiona el botón "Limpiar", al hacer esto, se borrarán todas las evaluaciones de los indicadores, de lo contrario, presiona "Cancelar".<br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onClick="limpia();">Aceptar</button>
                </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEnviar">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Terminar evaluación</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="terminarEvaluacion.php" id="formEvaluacion" method="post">
                <input type="hidden" name="idEvaluacion" value="<?=$idEvaluacion?>">
                <div class="modal-body">
                    ¿Estás seguro que deseas finalizar la evaluación?<br>
                    Al terminar la evaluación, <b>los indicadores que no hayas evaluado se registrarán con una calificación de 0</b><br>
                    Para finalizar la evaluación, elige las observaciones generales, realiza un comentario para el docente y da clic en el botón Terminar Evaluación<br>
                    <label for="observacionesGenerales"><b>Observaciones generales:</b></label>
                    <div class="form-group" style="overflow-y: scroll !important; height: 140px !important;">
                        <?php
                            $observaciones = $e->getObservaciones();
                            foreach($observaciones as $observacion){
                        ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="obs_<?=$observacion["idObservacion"]?>" id="obs_<?=$observacion["idObservacion"]?>">
                                    <label class="form-check-label" id="obs_<?=$observacion["idObservacion"]?>">
                                    <?=$observacion["observacion"]?>
                                    </label>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="observacionesGenerales"><b>Comentarios para el docente:</b></label>
                        <textarea style="resize: none;" class="form-control" name="comentarios" rows="2"></textarea>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onClick="document.getElementById('formEvaluacion').submit();">Terminar evaluación</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php
    }
?>