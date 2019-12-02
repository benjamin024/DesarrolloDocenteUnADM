<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    $folio = $_SESSION["usuario_UnADM"];

    require("../clases/docente.php");
    $d = new docente();
    $docente = $d->getDocente($folio);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Información del docente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap-toggle.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <link rel="stylesheet" href="../css/docentes.css">
    
    <script src="../js/jquery-3.3.1.min.js"></script>
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
    <?php
        $msg =@$_GET["msg"];
        if($msg == "FOLIO"){
            $modal = "$('#modalFolio').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }
        

        if(@$_GET["ok"]){
            $modal = "$('#modalOk').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }
        if(@$_GET["okNR"]){
            $modal = "$('#modalOkNR').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }
    ?>
    <div class="container-fluid" style="padding: 0px !important;">
        <div class="row" style="background-color: #FFF; position: absolute; width: 100%; height: 100px; margin: 0px; ">
            <img src="../img/sep.png" style="max-height: 60px; position: absolute; top: 5px; left: 100px;">
            <img src="../img/unadm.png" style="max-height: 60px; position: absolute; top: 5px; right: 100px;">
        </div>
        <?php
            include("../navbar-d.html");
        ?>
        <div class="row  h-100 aguila"  style="position: absolute; top: 0px; padding-top: 150px; width: 100%; z-index: -1; height:100%; margin: 0px;  justify-content: center;">
            <div class="col-md-2" style="">
                <br>
                <center>
                    <!--<a href="form_actualizarProfesor.php?folio=<?=$folio?>"><button style="width: 100%;" class="btn btn-success">Actualizar información</button></a><br><br>
                    <a href="infoDocente.php?folio=<?=$folio?>" target="_blank" class="boton"><button style="width: 100%;" class="btn btn-success">Reporte de datos</button></a>
                    <hr>-->
                    
                    <a href="calificacionesProfesor.php?folio=<?=$folio?>"><button style="width: 100%;" class="btn btn-success">Referencia de evaluación</button></a><br><br>
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
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tContacto" data-toggle="tab" href="#contacto" onClick="activa('tContacto');">Datos de contacto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tAcademica" data-toggle="tab" href="#academica" onClick="activa('tAcademica');">Formación académica</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tLaboral" data-toggle="tab" href="#laboral" onClick="activa('tLaboral');">Experiencia laboral</a>
                                </li>
                                </ul>
                            </div> <form class="form" action="" method="post">
                            <div class="card-body tab-content">
                               
                                <div id="general" class="container tab-pane active" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Folio:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" id="folio" value="<?=$docente["folio"]?>">
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
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>RFC:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["rfc"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>CURP:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=$docente["curp"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Lugar de nacimiento:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly class="form-control form-control-sm texto" value="<?=query("SELECT estado FROM estado WHERE clave = '".substr($docente["curp"], 11, 2)."'")->fetch_assoc()["estado"]?>">
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
                                        <!--
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Diplomado UnADM:</b></label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <label class="switch">
                                                    <input type="checkbox" <?=$checked?> disabled>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    -->
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
                
                <!---->
            </div>
        </div>

        <div class="modal fade" id="modalOkNR">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Contraseña no actualizada</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Decidiste utilizar la contraseña por defecto.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modalOk">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">¡Contraseña actualizada correctamente!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    La contraseña fue actualizada correctamente.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPsw">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 550px;">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cambio de contraseña</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Tu contraseña nunca ha sido actualizada. Por seguridad te recomendamos cambiarla
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" onclick="noRecordar()">No volver a mostrar</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Recordarme más tarde</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="$('#modalCambio').modal('toggle')">Cambiar ahora</button>
                </div>

                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modalCambio">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Actualización de contraseña</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <span style="padding: 15px; padding-bottom: 0px;">Tu nueva contraseña deberá tener entre 8 y 25 caracteres, entre los cuales debe haber por lo menos una mayúscula y un número</span>
                <form id="formEvaluacion">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label"><b>Ingresa tu nueva contraseña:</b></label>
                        <div class="col-sm-12">
                            <input type="password" maxlength="25" class="form-control" name="npass" id="npass">
                            <small style="color: #FF0000;" class="oculto" id="s_npass">Error</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label"><b>Confirma tu contraseña:</b></label>
                        <div class="col-sm-12">
                            <input type="password" maxlength="25" class="form-control" name="cpass" id="cpass">
                            <small style="color: #FF0000;" class="oculto" id="s_cpass">Error</small>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="enviaFormulario();">Aplicar</button>
                </div>
                </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function noRecordar(){
            $.post("../clases/ajax.php", {ACCION: "noRecordarPswDocente", folio: '<?=$folio?>'}, 
                function(result){
                    if(result == "1"){
                        window.location = "index.php?okNR=1";
                }
            });
        }

        function formatoPass(pass){
            var mayus = false;
            var num = false;
            for(i = 0; i < pass.length; i++){
                if(pass.charCodeAt(i) >= 65 && pass.charCodeAt(i) <= 90){
                    mayus = true;
                }
                if(pass.charCodeAt(i) >= 48 && pass.charCodeAt(i) <= 57){
                    num = true;
                }
            }

            return mayus & num;
        }

        function enviaFormulario(){
            var npass = $("#npass");
            var cpass = $("#cpass");
            var s_npass = $("#s_npass");
            var s_cpass = $("#s_cpass");
            var errores = 0;

            console.log(npass.val());
            console.log(cpass.val());
            if(npass.val().trim().length < 8 || npass.val().trim().length > 25){
                s_npass.removeClass("oculto");
                s_npass.html("La contraseña debe tener entre 8 y 25 caracteres");
                errores++;
            }

            if(!formatoPass(npass.val())){
                s_npass.removeClass("oculto");
                s_npass.html("La contraseña debe contener al menos una mayúscula y un número");
                errores++;
            }

            if(npass.val() != cpass.val()){
                s_cpass.removeClass("oculto");
                s_cpass.html("Las contraseñas no coinciden");
                errores++;
            } 

            if(!errores){
                $.post("../clases/ajax.php", {ACCION: "cambiaPswDocente", folio: '<?=$folio?>', pass: npass.val()}, function(result){
                    if(result == "1"){
                        window.location = "index.php?ok=1";
                    }
                });
            }
        }
    </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-toggle.js"></script>
</body>
</html>