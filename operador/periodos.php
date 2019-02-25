<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    setlocale(LC_ALL,"es_MX");
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    require("../clases/periodo.php");
    $p = new periodo();
    $periodoActual = $p->getPeriodoActual();
    $fechaFuturos = ($periodoActual)?$periodoActual["termino"]:date("Y-m-d");
    $fechaAnteriores = ($periodoActual)?$periodoActual["inicio"]:date("Y-m-d");
    $periodosFuturos = $p->getPeriodosFuturos($fechaFuturos);
    $periodosAnteriores = $p->getPeriodosAnteriores($fechaAnteriores);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Periodos</title>
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
                    <a href="#" class="boton"><button class="btn btn-danger">Registrar nuevo</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; overflow-y: auto;">
                <?php
                    if(!$periodoActual)
                        echo "<center>
                                  <br><h4>No hay periodo actual registrado</h4><br>                    
                              </center>";
                    else{
                ?>
                <center>
                    <br><h4>Periodo Actual</h4><br>                    
                </center>
                <div class="row">
                        <table class="table table-bordered table-sm">
                            <thead class="bg-successM" style="text-align: center;">
                                <th>Periodo</th>
                                <th>Inicio</th>
                                <th>Término</th>
                                <th>Permitir evaluaciones</th>
                            </thead>
                            <tbody style="text-align: center;">
                                <tr>
                                    <td class="align-middle"><?=$periodoActual["periodo"]?></td>
                                    <td class="align-middle"><?=strftime("%A %d de %B del %Y",strtotime($periodoActual["inicio"]))?></td>
                                    <td class="align-middle"><?=strftime("%A %d de %B del %Y",strtotime($periodoActual["termino"]))?></td>
                                    <td class="align-middle">
                                        <?php
                                            if($periodoActual["evaluaciones"])
                                                $checked = "checked";
                                            else
                                                $checked = "";
                                        ?>
                                            <label class="switch" style="margin-top: 10px;">
                                                <input type="checkbox" <?=$checked?> id="dip" name="dip">
                                                <span class="slider round"></span>
                                            </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
                <?php
                    }
                    if(sizeof($periodosFuturos) > 0){
                        echo "<center><br><h5>Próximos periodos</h5><br></center>";
                ?>
                        <div class="row">
                        <table class="table table-bordered table-sm">
                            <thead style="color: #FFF; text-align: center;">
                                <th style="background-color: #B38E5D;">Periodo</th>
                                <th style="background-color: #B38E5D;">Inicio</th>
                                <th style="background-color: #B38E5D;">Término</th>
                            </thead>
                            <tbody style="text-align: center;">
                <?php
                        foreach($periodosFuturos as $pF){
                ?>                            
                                <tr>
                                    <td class="align-middle"><?=$pF["periodo"]?></td>
                                    <td class="align-middle"><?=strftime("%A %d de %B del %Y",strtotime($pF["inicio"]))?></td>
                                    <td class="align-middle"><?=strftime("%A %d de %B del %Y",strtotime($pF["termino"]))?></td>
                                </tr>
                <?php
                        }
                        echo "</tbody></table></div>";
                    }
                    if(sizeof($periodosAnteriores) > 0){
                        echo "<center><br><h5>Periodos anteriores</h5><br></center>";
                ?>
                        <div class="row">
                        <table class="table table-bordered table-sm">
                            <thead style="color: #FFF; text-align: center;">
                                <th style="background-color: #B38E5D;">Periodo</th>
                                <th style="background-color: #B38E5D;">Inicio</th>
                                <th style="background-color: #B38E5D;">Término</th>
                            </thead>
                            <tbody style="text-align: center;">
                <?php
                        foreach($periodosAnteriores as $pA){
                ?>
                                <tr>
                                    <td class="align-middle"><?=$pA["periodo"]?></td>
                                    <td class="align-middle"><?=strftime("%A %d de %B del %Y",strtotime($pA["inicio"]))?></td>
                                    <td class="align-middle"><?=strftime("%A %d de %B del %Y",strtotime($pA["termino"]))?></td>
                                </tr>
                </div>
                <?php
                        }
                        echo "</tbody></table></div>";
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>