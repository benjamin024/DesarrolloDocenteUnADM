<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registrar nuevo docente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap-toggle.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <link rel="stylesheet" href="../css/docentes.css">
    <style>
        /* The switch - the box around the slider */
        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {display:none;}

        /* The slider */
        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: green;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px green;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
    </style>
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
    </script>
</head>
<body>
    <?php
        $msg =@$_GET["msg"];
        if($msg == "ERROR"){
            $modal = "$('#modalError').modal('toggle')";
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
                <center id='latmenu'>
                    <a href="docentes.php" class="boton"><button class="btn btn-danger">Cancelar</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; overflow-y: scroll;">
                <center><br><h4>Registrar nuevo docente</h4></center><br>
                <div class="row">
                    <div class="col-md-10 offset-md-1 align-self-center">
                        <form action="registrarProfesor.php" id="regForm" method="post" enctype="multipart/form-data">
                        <div class="card text-center">
                            <div class="card-header" style="background-color: rgba(212, 193, 156, 0.6); !important;">
                                <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link pestana active activa" id="tGeneral">Datos generales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tContacto" >Datos de contacto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pestana" id="tAcademica">Formación académica</a>
                                </li>
                                <!--<li class="nav-item">
                                    <a class="nav-link pestana" id="tLaboral">Experiencia laboral</a>
                                </li>-->
                                </ul>
                            </div>
                            <div class="card-body">
                               
                                <div class="tab" style="font-size:15px; text-align: right;">
                                        <div class="form-group row">
                                            <label for="img" class="col-sm-3 col-form-label"><b>Fotografía:</b></label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <div class="custom-file">
                                                <input type="file" name="img" id="img" class="form-control form-control-sm custom-file-input"  lang="es">
                                                <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Folio:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="folio" name="folio">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="apPaterno" class="col-sm-3 col-form-label"><b>Apellido paterno: </b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="apPaterno" name="apPaterno">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="apMaterno" class="col-sm-3 col-form-label"><b>Apellido materno:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="apMaterno" name="apMaterno">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nombre" class="col-sm-3 col-form-label"><b>Nombre(s):</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rfc" class="col-sm-3 col-form-label"><b>RFC:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="rfc" name="rfc">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="curp" class="col-sm-3 col-form-label"><b>CURP:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="curp" name="curp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab" style="font-size:15px; text-align: right; display: none;">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Estado de residencia:</b></label>
                                            <div class="col-sm-8">
                                            <select name="estado" id="estado" class="form-control form-control-sm"  onchange="cargaMunicipios(this.value, 0);">
                                                <option value="0" selected disabled>Seleccionar un estado</option>
                                            <?php
                                                include_once("../clases/database.php");
                                                $query = "SELECT * FROM estado";
                                                $resultado = query($query);
                                                while($r = $resultado->fetch_assoc()){
                                                    echo "<option value='".$r["clave"]."'>".$r["estado"]."</option>";
                                                }
                                            ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Municipio de residencia:</b></label>
                                            <div class="col-sm-8">
                                                <select name="municipio" id="municipio" class="form-control form-control-sm">
                                                    <option value="0" selected disabled>Seleccionar un municipio</option>
                                                    <script>cargaMunicipios('', 0);</script>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Teléfono de casa:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text"id="tel" name="tel" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Teléfono celular:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" id="cel" name="cel" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Correo electrónico institucional:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" id="mailInst" name="mailInst" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Correo electrónico personal:</b></label>
                                            <div class="col-sm-8">
                                                <input type="text" id="mailPers" name="mailPers" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab" style="font-size:15px; text-align: right; display: none;">
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Licenciatura:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="lic" class="form-control form-control-sm" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Maestría:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="maestria" class="form-control form-control-sm" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Doctorado:</b></label>
                                            <div class="col-sm-9">
                                                <input type="text"  name="doc" class="form-control form-control-sm" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Curso de inducción UnADM:</b></label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <label class="switch">
                                                    <input type="checkbox" name="induccion" >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="folio" class="col-sm-3 col-form-label"><b>Diplomado UnADM:</b></label>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <label class="switch">
                                                    <input type="checkbox" name="diplomado" >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!---<div class="tab"><br>
                                        <h3>En construcción</h3>
                                        <p>Esta pantalla se agregará en futuros módulos.</p>
                                    </div>-->
                                    <div style="overflow:auto;">
                                    <div style="float:right;">
                                        <button type="button" id="prevBtn" class="btn btn-success" onclick="nextPrev(-1)">Anterior</button>
                                        <button type="button" id="nextBtn" class="btn btn-success" onclick="nextPrev(1)">Siguiente</button>
                                    </div>
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
        <div class="modal" id="modalError">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">¡Ocurrió un error!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Ocurrió un error al momento de registrar al docente. Por favor inténtalo de nuevo.<br><br>
                    <small>Si el problema persiste, comunícate con el administrador del sistema.</small><br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the crurrent tab

        function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        console.log("n = " + n);
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Registrar";
        } else {
            document.getElementById("nextBtn").innerHTML = "Siguiente";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
        }

        function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        //alert("currentTab = " + currentTab + "\nn = " + n);
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            //alert("enviado");
            return true;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
        }

        function validateForm() {
        var valid = true;
        switch(currentTab){
            case 0:
                var folio = document.getElementById("folio");
                var aP = document.getElementById("apPaterno");
                var aM = document.getElementById("apMaterno");
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
                break;
            case 1:
                var estado = document.getElementById("estado");
                var mailInst = document.getElementById("mailInst");
                var mailPers = document.getElementById("mailPers");
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
                break;
            case 2:

        }
        return valid; // return the valid status
        }

        function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("pestana");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
            x[i].className = x[i].className.replace(" activa", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
        x[n].className += " activa";
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
                var selectMuns = document.getElementById("municipio");
                selectMuns.innerHTML = "<option value='0' selected disabled>Selecciona un municipio</option>";
                selectMuns.innerHTML += options;
            });
        }
    </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-toggle.js"></script>
</body>
</html>