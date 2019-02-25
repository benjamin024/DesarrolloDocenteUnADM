<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/materia.php");
    $m = new materia();
    $areas = $m->getListaAreas();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Áreas de conocimiento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <style>
        .link{
            color: #000;
            text-decoration: none;
        }
        .link:visited{
            color: #000;
            text-decoration: none;
        }
        .link:hover{
            color: #000;
            text-decoration: none;
        }
        .link:active{
            color: #000;
            text-decoration: none !active;
        }
    </style>
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
                    <a href="#" class="boton"><button class="btn btn-danger">Registrar nueva</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%;">
                <center>
                    <br><h4>Áreas de conocimiento</h4><br>                    
                </center>
                <div class="row">
                        <div id="accordion" style="width: 100%;">
                            <?php
                                foreach($areas as $area){
                            ?>
                                    <div class="card">
                                        <div class="card-header bg-successM" id="area<?=$area['idArea']?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link link" data-toggle="collapse" data-target="#collapse<?=$area['idArea']?>" aria-expanded="true" aria-controls="collapse<?=$area['idArea']?>" style="color: #FFF;">
                                            <?=$area["nombre"]?>
                                            </button>
                                        </h5>
                                        </div>

                                        <div id="collapse<?=$area['idArea']?>" class="collapse" aria-labelledby="area<?=$area['idArea']?>" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                <?php
                                                    $carreras = $m->getCarreras($area["idArea"]);
                                                    foreach($carreras as $carrera){
                                                        echo "<a href='carrera.php?id=".$carrera["idCarrera"]."&carrera=".$carrera["nombre"]."'  class='list-group-item link'>".$carrera["nombre"]."</a>";
                                                    }
                                                ?>
                                                <div class="" style="padding-top: 1em; text-align: right;">
                                                    <a href="form_editarArea.php?idArea=<?=$area['idArea']?>&nombre=<?=$area["nombre"]?>"><button class="btn btn-success">Editar área</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                    </div>
                </div>
                
                <!---->
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>