<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");

    require("../clases/evaluacion.php");
    $e = new evaluacion();
    $indicadores = $e->getIndicadores($_GET["idCriterio"]);
    $escala = $e->getEscalaEvaluacion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>iFrame</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <style>
        .activo{
            background-color: #D4C19C !important;
        }
    </style>
    <script>
        function evaluaIndicador(id){
            var calificaciones = [3, 6, 8, 10];
            var indicador = id.split("_")[0];
            var seleccionado = id.split("_")[1];
            for(var i = 0; i < 4; i++){
                document.getElementById(indicador + "_" + calificaciones[i]).classList.remove("activo");
            }
            document.getElementById(id).classList.add("activo");
            document.getElementById("cal_" + indicador).value = seleccionado;
        }
    </script>
</head>
<body>
    <form action="evaluarIndicador.php" method="post" target="_top">
    <input type="hidden" name="idEvaluacion" value="<?=$_GET["idEvaluacion"]?>">
    <table class="table table-bordered table-sm table-responsive">
        <thead class="bg-successM" style="text-align: center;">
            <tr>
                <th rowspan="2" width="50%" class="align-middle">Indicadores</th>
                <th colspan="<?=count($escala)?>" class="align-middle">Escala de Evaluación</th>
            </tr>
            <tr>
                <?php
                    foreach($escala as $esc){
                        echo "<th class='align-middle'>".$esc["texto"].", ".$esc["puntos"]." puntos</th>";
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                $indi = "";
                foreach($indicadores as $indicador){
                    echo "<tr>";
                    if($indicador["titulo"]){
                        $ind = "<b>".$indicador["titulo"].":</b><br>".nl2br($indicador["mensaje"]);
                    }else{
                        $ind = nl2br($indicador["mensaje"]);
                    }
                    echo "<td>$ind</td>";
                    $escalaEv = $e->getIndicadorEscala($indicador["idIndicador"]);
                    foreach($escalaEv as $eEv){
                        $qr = "SELECT count(*) activo FROM indicadorCalificacion WHERE idEvaluacion = ".$_GET["idEvaluacion"]." AND indicador = ".$indicador["idIndicador"]." AND calificacion = ".$eEv["escala"]; 
                        $activo = query($qr)->fetch_assoc()["activo"];
                        if($activo)
                            $activoC = "activo";
                        else
                            $activoC = "";
                        echo "<td class='$activoC' style='cursor: pointer;' id='".$indicador["idIndicador"]."_".$eEv["escala"]."' onclick='evaluaIndicador(this.id)'>".$eEv["texto"]."</td>";
                    }
                    echo "</tr>";
                    echo "<input type='hidden' id='cal_".$indicador["idIndicador"]."' name='cal_".$indicador["idIndicador"]."' value=''>";
                    $indi .= $indicador["idIndicador"]."--";
                }
            ?>
        </tbody>
        <input type="hidden" name="indicadores" value="<?=$indi?>">
    </table>
        <center><button class="btn btn-success">Guardar evaluación</button></center>
    </form>
</body>
</html>