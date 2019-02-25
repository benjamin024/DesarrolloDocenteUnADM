<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/materia.php");
    $m = new materia();
    $carrera = @$_GET["id"];
    $numModulos = $m->getNumeroModulos($carrera);
    $col = 12 / $numModulos * 2;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=@$_GET["carrera"]?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
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
                    <a href="materias.php" class="boton"><button class="btn btn-success">Regresar</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; height: 100%; overflow-y: auto;">
                <center>
                    <br><h4><?=@$_GET["carrera"]?></h4>                  
                </center>
                <div class="row">
                            <?php
                                $totalSemestres = 1;
                                for($i = 1; $i <= $numModulos; $i++){
                            ?>
                                    <div class="col-md-<?=$col?>">
                                    <div class="card" style="margin-top: 2em;">
                                        <div class="card-header bg-successM" id="modulo<?=$i?>" style="text-align: center;">
                                        <h5 class="mb-0">
                                            Módulo <?=$i?>
                                        </h5>
                                        </div>

                                        <div class="card-body">
                                            <?php
                                                $numSemestres = $m->getSemestresPorModulo($carrera, $i);
                                                
                                                $colS = 12/ $numSemestres;
                                                $numeroS = array("Primer", "Segundo", "Tercer", "Cuarto", "Quinto", "Sexto", "Séptimo", "Octavo", "Noveno", "Décimo");
                                            ?>
                                            <div class="row">
                                                <?php
                                                for($j = 0; $j < $numSemestres; $j++){
                                                ?>
                                                    <div class="col-md-<?=$colS?>">  
                                                        <center><b><?=$numeroS[$totalSemestres]?> semestre</b></center><br>
                                                        <ul>
                                                        <?php
                                                            $materias = $m->getMateriasSemestre($carrera, $i, $totalSemestres);
                                                            foreach($materias as $mat){
                                                                echo "<li>".$mat["nombre"]."</li>";
                                                            }
                                                        ?>
                                                        </ul>
                                                    </div>
                                                <?php
                                                $totalSemestres++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                    
                </div>
                <br>&nbsp;<br>
                <!---->
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>