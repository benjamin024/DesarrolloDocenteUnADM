<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    require("../clases/docente.php");
    $d = new docente();
    $folio = @$_GET["folio"];
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

        function seleccionaImagen(){
           var input = document.getElementById("img");
           input.click();
        }

        function eliminaImagen(){
            var img = document.getElementById("foto");
            foto.src = "../img/defaultprofile.jpg";
            var textHidden = document.getElementById("imgAux");
            textHidden.value = "default";
        }

        function valida(){
            var valid = true;
            var folio = document.getElementById("folio");
            var aP = document.getElementById("aP");
            var aM = document.getElementById("aM");
            var nombre = document.getElementById("nombre");
            var curp = document.getElementById("curp");
            if(!folio.value){
                folio.classList.add("is-invalid");
                folio.focus();
                valid = false;
            }else{
                folio.classList.remove("is-invalid");
            }
            if(!aP.value){
                aP.classList.add("is-invalid");
                aP.focus();
                valid = false;
            }else{
                aP.classList.remove("is-invalid");
            }
            if(!aM.value){
                aM.classList.add("is-invalid");
                aM.focus();
                valid = false;
            }else{
                aM.classList.remove("is-invalid");
            }
            if(!nombre.value){
                nombre.classList.add("is-invalid");
                nombre.focus();
                valid = false;
            }else{
                nombre.classList.remove("is-invalid");
            }
            if(!curp.value){
                curp.classList.add("is-invalid");
                curp.focus();
                valid = false;
            }else{
                curp.classList.remove("is-invalid");
            }
            var estado = document.getElementById("estado");
            var mailInst = document.getElementById("mailI");
            var mailPers = document.getElementById("mailP");
            if(estado.value == 0){
                estado.classList.add("is-invalid");
                estado.focus();
                valid = false;
            }else{
                estado.classList.remove("is-invalid");
            }
            if(!mailInst.value){
                mailInst.classList.add("is-invalid");
                mailInst.focus();
                valid = false;
            }else{
                mailInst.classList.remove("is-invalid");
            }
            if(!mailPers.value){
                mailPers.classList.add("is-invalid");
                mailPers.focus();
                valid = false;
            }else{
                mailPers.classList.remove("is-invalid");
            }
        return valid; // return the valid status
        }

        function envia(conf){
            var OK = valida();
            if(OK){
                if(conf){
                    var form = document.getElementById("actForm");
                    form.submit();
                }else{
                    $(document).ready(function(){$('#modalOk').modal('toggle')});
                }
            }else{
                $(document).ready(function(){$('#modalErrorForm').modal('toggle')});
            }
        }

        function cargaMunicipios(idEdo, SM){
            $.post("../clases/ajax.php", {ACCION: "cargaSelectMunicipios", estado: idEdo}, function(result){
                var municipios = result.split("--");
                //console.log(municipios);
                var options = "";
                municipios.forEach(function(valor, indice, array){
                    if(valor != ""){
                        var municipio = valor.split("-");
                        var selected = "";
                        if(SM == municipio[0])
                            selected = "selected";
                        options += "<option value='"+municipio[0]+"' "+selected+">"+municipio[1]+"</option>";
                    }
                });
                //console.log(options);
                var selectMuns = document.getElementById("mun");
                selectMuns.innerHTML = "<option value='0' selected disabled>Selecciona un municipio</option>";
                selectMuns.innerHTML += options;
            });
        }

    </script>
</head>
<body>
    <?php
        $folio =@$_GET["folio"];
        $msg =@$_GET["msg"];
        if($msg == "ErrorFolio"){
            $modal = "$('#modalErrorFolio').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }
        if($msg == "ErrorAct"){
            $modal = "$('#modalErrorAct').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }
        if($msg == "OK"){
            $modal = "$('#modalOkAct').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }
    ?>
    <div class="container-fluid" style="padding: 0px !important;">
        <div class="row" style="background-color: #FFF; position: absolute; width: 100%; height: 100px; margin: 0px; ">
            <img src="../img/sep.png" style="max-height: 60px; position: absolute; top: 5px; left: 100px;">
            <img src="../img/unadm.png" style="max-height: 60px; position: absolute; top: 5px; right: 100px;">
        </div>
        <?php
            include("../navbar.html");
        ?>
        <div class="row  h-100 aguila"  style="position: absolute; top: 0px; padding-top: 126px; width: 100%; z-index: -1; height:100%; margin: 0px;  justify-content: center;">
            <div class="col-md-2" style="">
                <br>
                <center>
                    <button style="width: 100%;" onClick="envia();" class="btn btn-success">Actualizar información</button><br><br>
                    <a href="fichaProfesor.php?folio=<?=$folio?>" class="boton"><button style="width: 100%;" class="btn btn-danger">Cancelar</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; overflow-y: auto;">
                <center><br><h4>Actualizar la información de <?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></h4></center><br>
                <div class="row">
                    <div class="col-md-2">
                        <?php
                        if($docente["img"]){
                        ?>
                            <img id="foto" src="../img/docentes/<?=$docente["folio"]?>.jpg" width="100%"><br><br>
                            
                        <?php
                        }else{
                        ?>
                            <img id ="foto" src="../img/defaultprofile.jpg" width="100%"><br><br>
                        <?php
                        }
                        ?>
                        <button style="width: 100%;" id="changeImg" onClick="seleccionaImagen();" class="btn btn-success btn-sm">Cambiar imagen</button></a><br><br>
                            <button style="width: 100%;" id="deleteImg" onClick="eliminaImagen();" class="btn btn-danger btn-sm">Eliminar imagen</button></a><br><br>
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
                            </div> <form class="form" action="actualizarProfesor.php" enctype="multipart/form-data" id="actForm" method="post">
                                <input type="file" hidden name="img" id="img">
                                <input type="text" hidden name="imgAux" id="imgAux" value="selected">
                                <input type="text" name="folioAux" hidden value="<?=$docente["folio"]?>">
                            <div class="card-body tab-content">
                               
                                <div id="general" class="container tab-pane active" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Folio:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="folio" name="folio" value="<?=$docente["folio"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Apellido paterno: </b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="aP" name="aP" value="<?=$docente["apPaterno"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label texto"><b>Apellido materno:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="aM" name="aM" value="<?=$docente["apMaterno"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Nombre(s):</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="nombre" name="nombre" value="<?=$docente["nombres"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>RFC:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="rfc" name="rfc" value="<?=$docente["rfc"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>CURP:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="curp" name="curp" value="<?=$docente["curp"]?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="contacto" class="container tab-pane fade" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Estado de residencia:</b></label>
                                            <div class="col-sm-8">
                                            <select name="estado" id="estado" class="form-control form-control-sm" onchange="cargaMunicipios(this.value, 0);">
                                                <option value="0" disabled>Seleccionar un estado</option>
                                            <?php
                                                include_once("../clases/database.php");
                                                $query = "SELECT * FROM estado";
                                                $resultado = query($query);
                                                while($r = $resultado->fetch_assoc()){
                                                    if($r["clave"] == $docente["estado"])
                                                        $s = "selected ";
                                                    else
                                                        $s = "";
                                                    echo "<option value='".$r["clave"]."' $s>".$r["estado"]."</option>";
                                                }
                                            ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Municipio de residencia:</b></label>
                                            <div class="col-sm-8">
                                                <select name="mun" id="mun" class="form-control form-control-sm">
                                                    <option value="0" disabled>Seleccionar un municipio</option>
                                                    <script>cargaMunicipios('<?=$docente["estado"]?>', <?=$docente["mun"]?>);</script>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Teléfono de casa:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm texto" id="tel" name="tel" value="<?=$docente["tel"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Teléfono celular:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm texto" id="cel" name="cel" value="<?=$docente["cel"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Correo electrónico institucional:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm texto" id="mailI" name="mailI" value="<?=$docente["mailInst"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Correo electrónico personal:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm texto" id="mailP" name="mailP" value="<?=$docente["mailPers"]?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="academica" class="container tab-pane fade" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Licenciatura:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="lic" name="lic" value="<?=$docente["lic"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Maestría:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="mc" name="mc" value="<?=$docente["maestria"]?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Doctorado:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm texto" id="doc" name="doc" value="<?=$docente["doc"]?>">
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
                                                    <input type="checkbox" <?=$checked?> id="ind" name="ind">
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
                                                    <input type="checkbox" <?=$checked?> id="dip" name="dip">
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
                
                <!---->
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal" id="modalErrorForm">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Datos incompletos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Faltan algunos datos para poder actualizar la información del docente.<br>
                    Se han marcado de color rojo para que los puedas identificar de mejor manera.<br>
                    Comprueba y completa los datos y vuelve a intentarlo
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal" id="modalErrorFolio">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">El folio ingresado ya existe</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <?php
                        $folioA = @$_GET["folioA"];
                        $docente2 = $d->getDocente($folioA);
                    ?>
                    El folio que se trató de actualizar ya existe en el sistema y está asignado al docente <b><?=$docente2["nombres"]." ".$docente2["apPaterno"]." ".$docente2["apMaterno"]?>.</b><br>
                    A continuación puedes ver la información de dicho docente o intentar de nuevo con otro folio.<br><br>
                    <small>Si crees que se trata de un error, comunícate con el administrador del sistema.</small><br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">         
                    <button  data-dismiss="modal" class="btn btn-success">Intentar con otro folio</button>
                    <a href="fichaProfesor.php?folio=<?=$folioA?>"><button type="button" class="btn btn-success" >Ver información</button></a>
                </div>

                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal" id="modalErrorAct">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">¡Ocurrió un error!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Ocurrió un error al momento de actualizar la información del docente. Por favor inténtalo de nuevo.<br><br>
                    <small>Si el problema persiste, comunícate con el administrador del sistema.</small><br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>

        <div class="modal" id="modalOkAct">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">¡Datos actualizados correctamente!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div>
                    Los datos del docente <b><?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></b> se actualizaron correctamente en el sistema.<br>
                    A continuación puedes ver su ficha de información.<br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="fichaProfesor.php?folio=<?=$folio?>"><button type="button" class="btn btn-success">Ver información</button></a>
                </div>

                </div>
            </div>
        </div>

        <div class="modal" id="modalOk">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Confirma la actualización</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    ¿Estás seguro que deseas actualizar los datos de <b><?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></b>?<br>
                    Si es así, presiona el botón "Aceptar" de lo contrario, presiona "Cancelar".<br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onClick="envia(true);">Aceptar</button>
                </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('img').onchange = function (evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            // FileReader support
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function () {
                    document.getElementById("foto").src = fr.result;
                    var textHidden = document.getElementById("imgAux");
                    textHidden.value = "changed";
                }
                fr.readAsDataURL(files[0]);
            }

            // Not supported
            else {
                // fallback -- perhaps submit the input to an iframe and temporarily store
                // them on the server until the user's session ends.
            }
        }
    </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-toggle.js"></script>
</body>
</html>