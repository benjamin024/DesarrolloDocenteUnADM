<?php
    require("../clases/evaluacion.php");
    $e = new evaluacion();
    $idIndicador = @$_GET["idIndicador"];
    $indicador = $e->getIndicador($idIndicador)[0];
    $idCriterio = @$_GET["idCriterio"];
    $criterio =@$_GET["criterio"];
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
</head>
<body>
    <form action="editarIndicador.php" method="post" target="_top">
        <table class="table table-bordered table-sm table-responsive">
            <thead class="bg-successM" style="text-align: center;">
                <tr>
                    <th rowspan="2" width="60%" class="align-middle">Indicador</th>
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
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="Título" name="nombre" value="<?=$indicador['titulo']?>">
                        <textarea class="form-control" rows="10" name="mensaje" placeholder="Indicador" style="resize: none;"><?=$indicador["mensaje"]?></textarea>
                    </td>
                    <?php
                        $escalaEv = $e->getIndicadorEscala($indicador["idIndicador"]);
                        $cal = array("eval10","eval8","eval6","eval3");
                        $i = 0;
                        foreach($escalaEv as $eEv){
                    ?>
                            <td><textarea class="form-control" rows="11" name="<?=$cal[$i]?>" placeholder="Calificación" style="resize: none;"><?=$eEv["texto"]?></textarea></td>
                    <?php
                            $i++;
                        }
                    ?>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="idIndicador" value="<?=$idIndicador?>">
        <input type="hidden" name="idCriterio" value="<?=$idCriterio?>">
        <input type="hidden" name="criterio" value="<?=$criterio?>">
        <center><button class="btn btn-success">Guardar cambios</button></center>
    </form>
</body>
</html>