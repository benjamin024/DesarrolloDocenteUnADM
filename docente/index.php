<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/docente.php");
    $d = new docente();
    $docente = $d->getDocente($_SESSION["usuario_UnADM"]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pantalla de inicio para docentes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap-toggle.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <style>
        .emergente{
            transition: .5s ease;
            opacity: 0;
            position:absolute;
            word-wrap: break-word;
            width: 100%;
            height: 100%;
            top:0%;
            left: 15px;
            text-align: center;
            cursor: pointer;
            border-radius: 20px;
          }

        .header:hover .emergente{
            opacity:1;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    
</head>
<body>
    <?php
        if($docente["flagPsw"]){
            $modal = "$('#modalPsw').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }

        require("../clases/ajuste.php");

        $a = new ajuste();

        $bloques = $a->getBloques(1);
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
            <div class="col-md-12 align-items-center" style="padding: 0 5%; overflow-y: auto;">
                <center>
                    <br><h4>Pantalla de inicio para docentes</h4><br>   
                    <div class="row">
                        <?php
                            foreach($bloques as $b){
                        ?>
                            <div class="col-md-4" style="margin-bottom: 30px;">
                            <a href="<?=$b['link']?>">
                            <div id="bloque" class="row h-100 header" style="position: relative; width: 100%; height: 130px; cursor: pointer; border-radius: 20px; padding: 10px; background-color: <?=$b['color']?>;" onmouseover="$('#bloque-textodiv').attr('hidden', false)" onmouseleave="$('#bloque-textodiv').attr('hidden', true)">
                                <img id="imagen" style="margin: auto;" src="../img/ajustes/docentes/<?=$b['imagen']?>" height="110px">
                                <div class="emergente row h-100" id="bloque-textoDiv" style="background-color: <?=$b['color']?>;">
                                    <h5 id="bloque-texto" style="margin: auto; color: #FFF;"><?=$b['titulo']?></h5>
                                </div>
                            </div>
                            </a>
                        </div>
                        <?php
                            }
                        ?>
                    </div>          
                </center>
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