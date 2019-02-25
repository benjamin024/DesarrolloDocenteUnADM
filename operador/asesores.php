<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/asesor.php");
    $a = new asesor;
    $busqueda = @$_GET["busqueda"];
    if(!empty($busqueda)){
        $lista = $a->getBusquedaAsesores($busqueda);
    }else{
        $lista = $a->getListaAsesores();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lista de asesores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <link rel="stylesheet" href="../css/docentes.css">
    <script>
        function seleccionaAsesor(folio, id) {
            var menu = document.getElementById("latmenu");
            menu.innerHTML = "<a href='form_registrarAsesor.php' class='boton'><button class='btn btn-danger'>Registrar nuevo</button></a><br><br>";
            menu.innerHTML += "<a href='fichaAsesor.php?rfc="+folio+"' id='infoLink' class='boton'><button id='infoBtn' class='btn btn-success'>Ver información</button></a><br><br>";
            <?php
                if(!empty($busqueda)){
            ?>
                    menu.innerHTML += "<a href='asesores.php' class='boton'><button class='btn btn-success'>Ver lista completa</button></a><br><br>"
            <?php
                }
            ?>
            var els = document.querySelectorAll('.docente.activo');
            for (var i = 0; i < els.length; i++) {
                els[i].classList.remove('activo');
            }
            var seleccionado = document.getElementById(id);
            seleccionado.classList.add("activo");
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
                    <a href="form_registrarAsesor.php" class="boton"><button class="btn btn-danger">Registrar nuevo</button></a><br><br>
                    <?php
                        if(!empty($busqueda)){
                    ?>
                            <a href="asesores.php" class="boton"><button class="btn btn-success">Ver lista completa</button></a><br><br>
                    <?php
                        }
                    ?>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; overflow-y: auto;">
                <center>
                    <br><h4>Asesores registrados</h4><br>
                    <div class="col-md-8" style="padding: 0 !important;">
                            <form id="busca" action="asesores.php" method="get" class="form">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" name="busqueda" value="<?=$busqueda?>" placeholder="Buscar asesor" >
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                            </div>
                            </form>
                    </div>
                    
                </center><br>
                <div class="row">
                        <div class="card text-center" style="width: 100%;">
                            <div class="card-body row">
                                <div class="col-md-6 col-sm-12 list-group">
                                    <?php
                                    if(count($lista) > 0){
                                    for($i = 0; $i <= floor(count($lista)/2); $i++){
                                    ?>
                                        <span style="cursor: pointer;" id="d<?=$i?>" onClick="seleccionaAsesor('<?=$lista[$i]["rfc"]?>','d<?=$i?>')" class="list-group-item list-group-item-action flex-column align-items-start docente">
                                            <div class="d-flex w-100">
                                                <?php
                                                if($lista[$i]["img"]){
                                                ?>
                                                    <img src="../img/asesores/<?=$lista[$i]["rfc"]?>.jpg" class="rounded-circle" style="max-width: 40px; max-height: 40px;">&nbsp;&nbsp;&nbsp;
                                                <?php
                                                }else{
                                                ?>
                                                    <img src="../img/defaultprofile.jpg" class="rounded-circle" style="max-width: 40px; max-height: 40px;">&nbsp;&nbsp;&nbsp;
                                                <?php
                                                }
                                                ?>
                                                <?=$lista[$i]["apPaterno"]." ".$lista[$i]["apMaterno"]." ".$lista[$i]["nombres"]?>
                                            </div>
                                            </span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6 col-sm-12 list-group">
                                     <?php
                                    for($i = floor(count($lista)/2)+1; $i < count($lista); $i++){
                                    ?>
                                        <span style="cursor: pointer;" id="d<?=$i?>" onClick="seleccionaAsesor('<?=$lista[$i]["rfc"]?>','d<?=$i?>')" class="list-group-item list-group-item-action flex-column align-items-start docente">
                                            <div class="d-flex w-100">
                                                <?php
                                                if($lista[$i]["img"]){
                                                ?>
                                                    <img src="../img/asesores/<?=$lista[$i]["rfc"]?>.jpg" class="rounded-circle" style="max-width: 40px; max-height: 40px;">&nbsp;&nbsp;&nbsp;
                                                <?php
                                                }else{
                                                ?>
                                                    <img src="../img/defaultprofile.jpg" class="rounded-circle" style="max-width: 40px; max-height: 40px;">&nbsp;&nbsp;&nbsp;
                                                <?php
                                                }
                                                ?>
                                                <?=$lista[$i]["apPaterno"]." ".$lista[$i]["apMaterno"]." ".$lista[$i]["nombres"]?>
                                            </div>
                                        </span>
                                    <?php
                                    }
                                }else{
                                    echo "<b>No se encontraron resultados</b>";
                                }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <br>&nbsp;<br>
                </div>
                
                <!---->
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>