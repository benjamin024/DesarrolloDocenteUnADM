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
    <title>Estadísticas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
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
                    <a href="form_agregaArchivo.php" target="iframeEst" class="boton" onclick="document.getElementById('titulo').innerHTML = 'Agregar archivo';"><button class="btn btn-danger">Agregar archivos</button></a><br><br>
                    <a href="estadisticasDocentes.php" target="iframeEst" class="boton" onclick="document.getElementById('titulo').innerHTML = 'Estadísticas sobre docentes';"><button class="btn btn-success">Docentes</button></a><br><br>
                    <a href="estadisticasGeo.php" class="boton"><button class="btn btn-success">Estadísticas geográficas</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center">
                <br>
                <center><h3 id="titulo">Estadísticas sobre docentes</h3></center>
                <iframe name="iframeEst" style="padding-left:150px" src="estadisticasDocentes.php" width="100%" height="100%" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>