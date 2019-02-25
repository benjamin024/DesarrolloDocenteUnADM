<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    require("../clases/ajuste.php");

    $a = new ajuste();

    $bloques = $a->getBloques(2);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pantalla de inicio para asesores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
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
                    <a href="confInicioDocentes.php" class="boton"><button class="btn btn-success">Pantalla de inicio Docentes</button></a><br><br>
                    <a href="confInicioAsesores.php" class="boton"><button class="btn btn-success">Pantalla de inicio Asesores</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0px 50px; overflow-y: scroll;">
                <center>
                    <br><h4>Pantalla de inicio para asesores</h4><br>   
                    <div class="row">
                        <?php
                            foreach($bloques as $b){
                        ?>
                            <div class="col-md-4" style="margin-bottom: 30px;">
                            <a href="form_editarBloque.php?bloque=<?=$b['id']?>">
                            <div id="bloque" class="row h-100 header" style="position: relative; width: 100%; height: 130px; cursor: pointer; border-radius: 20px; padding: 10px; background-color: <?=$b['color']?>;" onmouseover="$('#bloque-textodiv').attr('hidden', false)" onmouseleave="$('#bloque-textodiv').attr('hidden', true)">
                                <img id="imagen" style="margin: auto;" src="../img/ajustes/docentes/<?=$b['imagen']?>" height="110px">
                                <div class="emergente row h-100" id="bloque-textoDiv" style="background-color: <?=$b['color']?>;">
                                    <?php
                                        $color = ($b['fuente'])?"#000":"#fff";
                                    ?>
                                    <h5 id="bloque-texto" style="margin: auto; color: <?=$color?>;"><?=$b['titulo']?></h5>
                                </div>
                            </div>
                            </a>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <a href="form_nuevoBloque.php?tipo=2" class="boton" style="margin-bottom: 30px;"><button class="btn btn-success">Agregar nuevo bloque</button></a>     <br>&nbsp;            
                </center>
            </div>
        </div>

    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>