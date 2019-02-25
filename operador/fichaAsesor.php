<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/asesor.php");
    $a = new asesor;
    $rfc = @$_GET["rfc"];
    $docente = $a->getAsesor($rfc);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Información del asesor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <link rel="stylesheet" href="../css/docentes.css">
    <script>
        function activa(seleccionado) {
            var sel = document.getElementById(seleccionado);
            sel.classList.add("activa");
            switch(seleccionado){
                case "tGeneral":
                    document.getElementById("tContacto").classList.remove("activa");
                    document.getElementById("tAcademica").classList.remove("activa");
                    document.getElementById("tLaboral").classList.remove("activa");
                    break;
                case "tContacto":
                    document.getElementById("tGeneral").classList.remove("activa");
                    document.getElementById("tAcademica").classList.remove("activa");
                    document.getElementById("tLaboral").classList.remove("activa");
                    break;
                case "tAcademica":
                    document.getElementById("tContacto").classList.remove("activa");
                    document.getElementById("tGeneral").classList.remove("activa");
                    document.getElementById("tLaboral").classList.remove("activa");
                    break;
                case "tLaboral":
                    document.getElementById("tContacto").classList.remove("activa");
                    document.getElementById("tAcademica").classList.remove("activa");
                    document.getElementById("tGeneral").classList.remove("activa");
            }
        }

        function getPeriodosDisponibles(evaluacion, docente){
            $.post("../clases/ajax.php", {ACCION: "evaluacionesDisponibles", evaluacion: evaluacion, docente: docente}, function(result){
                var periodos = result.split("--");
                var options = "";
                periodos.forEach(function(valor, indice, array){
                    if(valor != ""){
                        options += "<option value='"+valor+"'>"+valor+"</option>";
                    }
                });
                var selectPeriodos = document.getElementById("evalPeriodo");
                selectPeriodos.innerHTML = "<option value='0' selected disabled>Selecciona un periodo</option>";
                selectPeriodos.innerHTML += options; 
            });
        }

        function enviaFormulario(){
            var ev = $("#evaluacion").val();
            var per = $("#evalPeriodo").val();

            if(ev && per){
                document.getElementById("formEvaluacion").submit();
            }else{
                alert("Debes seleccionar una evaluación y un periodo");
            }
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
                    <a href="asesores.php" class="boton"><button style="width: 100%;" class="btn btn-success">Regresar</button></a><br><br>
                    <a href="form_actualizarAsesor.php?folio=<?=$folio?>"><button style="width: 100%;" class="btn btn-success">Administrar permisos</button></a><br><br>
                    <!--<a href="infoDocente.php?folio=<?=$folio?>" target="_blank" class="boton"><button style="width: 100%;" class="btn btn-success">Reporte de datos</button></a>
                    <hr>
                    <button style="width: 100%;" class="btn btn-success" onclick="$('#modalEvaluacion').modal('toggle')">Aplicar evaluación</button><br><br>
                    <a href="calificacionesProfesor.php?folio=<?=$folio?>"><button style="width: 100%;" class="btn btn-success">Ver calificaciones</button></a><br><br>-->
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; overflow-y: auto;">
                <center><br><h4>Información general de <?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></h4></center><br>
                <div class="row">
                    <div class="col-md-2">
                        <?php
                        if($docente["img"]){
                        ?>
                            <img src="../img/docentes/<?=$docente["folio"]?>.jpg" width="100%"><br>
                        <?php
                        }else{
                        ?>
                            <img src="../img/defaultprofile.jpg" width="100%">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-10 align-self-center">
                        <div class="card text-center">
                            <div class="card-header" style="background-color: rgba(212, 193, 156, 0.6); !important;">
                                <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link pestana active activa" id="tGeneral" data-toggle="tab" href="#general" onClick="activa('tGeneral');">Datos generales</a>
                                </li>
                                <!--
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tContacto" data-toggle="tab" href="#contacto" onClick="activa('tContacto');">Datos de contacto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tAcademica" data-toggle="tab" href="#academica" onClick="activa('tAcademica');">Formación académica</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tLaboral" data-toggle="tab" href="#laboral" onClick="activa('tLaboral');">Experiencia laboral</a>
                                </li>
                                -->
                                </ul>
                            </div> <form class="form" action="" method="post">
                            <div class="card-body tab-content">
                               
                                <div id="general" class="container tab-pane active" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>RFC:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["rfc"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Apellido paterno: </b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["apPaterno"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" readonly class="col-sm-3 col-form-label texto"><b>Apellido materno:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["apMaterno"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Nombre(s):</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["nombres"]?>">
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <div id="contacto" class="container tab-pane fade" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Estado de residencia:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["edo"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Municipio de residencia:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["municipio"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Teléfono de casa:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["tel"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Teléfono celular:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["cel"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Correo electrónico institucional:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["mailInst"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Correo electrónico personal:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["mailPers"]?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="academica" class="container tab-pane fade" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Licenciatura:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["lic"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Maestría:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["maestria"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Doctorado:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["doc"]?>">
                                            </div>
                                        </div>
                                        <?php
                                            if($docente["induccion"])
                                                $checked = "checked";
                                            else
                                                $checked = "";
                                        ?>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Curso de inducción UnADM:</b></label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <label class="switch">
                                                    <input type="checkbox" <?=$checked?> disabled>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php
                                            if($docente["diplomado"])
                                                $checked = "checked";
                                            else
                                                $checked = "";
                                        ?>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Diplomado UnADM:</b></label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <label class="switch">
                                                    <input type="checkbox" <?=$checked?> disabled>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="laboral" class="container tab-pane fade"><br>
                                        <h3>En construcción</h3>
                                        <p>Esta pantalla se agregará en futuros módulos.</p>
                                    </div>
                            </div> 
                        </form>
                        </div>
                        <br>&nbsp;<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>