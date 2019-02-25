<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    require("../clases/ajuste.php");

    $a = new ajuste();

    $bloque = $a->getBloque(@$_GET["bloque"]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar bloque</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <script>
        function selecciona(archivo){
            console.log(archivo.files[0].type);
            if(archivo.files[0].type == "image/png" || archivo.files[0].type == "image/jpeg"){            document.getElementById("fileName").value = archivo.files[0].name;
                var reader = new FileReader();
                reader.readAsDataURL(archivo.files[0]);
                reader.onload = function (e) {
                    var image=new Image();
                    image.src=e.target.result;
                    image.onload = function () {
                        document.getElementById("imagen").src=image.src;
                    };
                }
            }else{
                $("#inputFile").val(null);
                document.getElementById("fileName").value = "";
            }

        }

        function seleccionaColor(color){
            document.getElementById("colorBtn").style.backgroundColor = color;
            document.getElementById("colorBtn").placeholder = "";

            document.getElementById("bloque").style.backgroundColor = color;
            document.getElementById("bloque-textoDiv").style.backgroundColor = color;
        }

        function cambiaFuente(negro){
            var color = "";
            if(negro)
                color = "#000";
            else
                color = "#FFF";

            document.getElementById("bloque-texto").style.color = color;
        }

        function vistaPrevia(){
            $("#bloque-texto").html(document.getElementById("titulo").value);
            $('#modalVP').modal('toggle');
        }

        function envia(){
                document.getElementById("formulario").submit();
        }

        function eliminaBloque(){
            
            $.post("eliminaBloque.php", {idBloque: <?=@$_GET["bloque"]?>}, function(result){
                if(result == 1){
                    window.location = "confInicioDocentes.php";
                }else{
                    console.log("no se eliminó!");
                }
            });
        }
    </script>
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
        background-color: #fff;
        border: solid 1px #ccc;
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
        border: solid 1px #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: black;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px black;
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
                    <a href="confInicioDocentes.php" class="boton"><button class="btn btn-success">Regresar</button></a><br><br>
                    <button class="btn btn-danger" onclick="$('#modalConfirma').modal('toggle');">Eliminar bloque</button><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center">
                <center>
                    <br><h4>Editar bloque</h4><br> 
                <?php
                    if(!$bloque)
                        die("<h6>Error en el ID del bloque</h6>");
                ?>
                </center>  
                    <div class="col-md-6 offset-md-3">
                    <form id="formulario" action="editarBloque.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingresa el título del bloque" value="<?=$bloque['titulo']?>">
                        </div>
                        <div class="form-group">
                            <label for="seccion">Imagen:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nombreImagen" id="fileName" readonly style="background: #FFF;" value="<?=$bloque['imagen']?>" placeholder="Agrega un archivo"  aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" id="button-addon2" onclick="document.getElementById('inputFile').click();">Seleccionar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-10">
                        <div class="form-group">
                            <label for="seccion">Color:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="colorBtn" readonly style="background: <?=$bloque['color']?>;"  aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" id="button-addon2" onclick="document.getElementById('color').click();">Seleccionar</button>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-2">
                            <label for="seccion">Fuente:</label>
                        <div class="form-group">
                            <?php
                                $fuente = ($bloque["fuente"])?"checked":"";
                            ?>
                            <label class="switch">
                                <input type="checkbox" id="fuente" name="fuente" onchange="cambiaFuente(this.checked)" <?=$fuente?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="titulo">Link:</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Ingresa la URL a la que llevará el bloque" value="<?=$bloque['link']?>">
                        </div>
                        <br>
                        <input type="file" hidden name="inputFile" id="inputFile" onchange="selecciona(this);">
                        <input type="color" hidden name="color" id="color" onchange="seleccionaColor(this.value);" value="<?=$bloque['color']?>">
                        <input type="hidden" name="id" value="<?=@$_GET['bloque']?>">
                        <center><button type="button" onclick="vistaPrevia();" class="btn btn-success">Vista previa</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" onclick="envia();" class="btn btn-success">Editar bloque</button></center>
                    </form>       
                    </div>  
            </div>
        </div>

        <div class="modal fade" id="modalVP">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Vista previa del bloque</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <center>
                    <div id="bloque" class="row h-100 header" style="position: relative; width: 100%; height: 130px; cursor: pointer; border-radius: 20px; padding: 10px; background-color: <?=$bloque['color']?>;" onmouseover="$('#bloque-textodiv').attr('hidden', false)" onmouseleave="$('#bloque-textodiv').attr('hidden', true)">
                        <img id="imagen" style="margin: auto;" src="../img/ajustes/docentes/<?=$bloque['imagen']?>" height="110px">
                        <div class="emergente row h-100" id="bloque-textoDiv" style="background-color: <?=$bloque['color']?>;">
                            <h5 id="bloque-texto" style="margin: auto; color: #FFF;"><?=$bloque['titulo']?></h5>
                        </div>
                    </div>
                    </center>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modalConfirma">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">¿Realmente deseas eliminar este bloque?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form class="form" id="formEditaCriterio" method="post" action="editarCriterio.php">
                <div class="modal-body">
                    Si lo eliminas, se perderá toda la información relacionada con este bloque.
                </div>
                </form>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button></a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="eliminaBloque();">Sí, eliminar</button>
                </div>

                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>