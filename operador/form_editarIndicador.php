<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();
    $idCriterio = @$_GET["idCriterio"];
    $criterio = @$_GET["criterio"];
    $indicadores = $e->getIndicadores($idCriterio);
    $escala = $e->getEscalaEvaluacion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar indicadores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <script>
        var rG, idG;

        function eliminaIndicador(){
            
            $.post("eliminaIndicador.php", {idIndicador: idG}, function(result){
                if(result == 1){
                    var i = rG.parentNode.parentNode.rowIndex;
                    document.getElementById("indicadoresTabla").deleteRow(i);
                    document.getElementById("numIndicadores").value = document.getElementById("numIndicadores").value - 1;
                }else{
                    console.log("no se eliminó!");
                }
            });
        }

        function abreModal(id){
            document.getElementById("iframeModal").setAttribute("src", "iframe_editarIndicador.php?idIndicador="+id+"&idCriterio=<?=$idCriterio?>&criterio=<?=$criterio?>");
            $('#modalEditaIndicador').modal('toggle')
        }

        function abreModal2(){
            document.getElementById("iframeModal2").setAttribute("src", "iframe_agregarIndicador.php?idCriterio=<?=$idCriterio?>&criterio=<?=$criterio?>");
            $('#modalAgregaIndicador').modal('toggle')
        }

        function confirmaEliminar(r, id){
            rG = r;
            idG = id;
            $('#modalConfirma').modal('toggle');
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
                    <a href="evaluaciones.php" class="boton"><button class="btn btn-danger">Regresar</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%; height: 100%; overflow-y: auto;">
                <center>
                    <br><h4>Editar indicadores de <?=$criterio?></h4><br>                    
                </center>
                <div class="row">
                        <table class="table table-bordered table-sm table-responsive" id="indicadoresTabla">
                            <thead class="bg-successM" style="text-align: center;">
                                <tr>
                                    <th rowspan="2" width="55%" class="align-middle">Indicadores</th>
                                    <th colspan="<?=count($escala)?>" class="align-middle">Escala de Evaluación</th>
                                    <th rowspan="2" class="align-middle">Opciones</th>
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
                                            echo "<td>".$eEv["texto"]."</td>";
                                        }
                                ?>
                                        <td style="text-align: center;"><br><button class="btn btn-success" onclick='abreModal("<?=$indicador['idIndicador']?>");'>Editar</button><br><br><button class="btn btn-danger" onclick="confirmaEliminar(this,'<?=$indicador["idIndicador"]?>')">Eliminar</button></td>
                                <?php
                                        echo "</tr>";
                                    }
                                ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;"><button type="button" onclick="abreModal2();" class="btn btn-success">Agregar indicador</button></td>
                                </tr>
                            </tbody>
                        </table><br>
                        <center></center>
                </div>
                
                <!---->
                
            </div>
        </div>

        <div class="modal fade" id="modalAgregaIndicador">
            <div class="modal-dialog modal-lg" style=" max-width: 1200px !important;">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar indicador</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" style="height: 520px;">
                    <iframe id="iframeModal2" src="" width="100%" height="100%" frameborder="0"></iframe>
                </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditaIndicador">
            <div class="modal-dialog modal-lg" style=" max-width: 1200px !important;">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Editar indicador</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" style="height: 520px;">
                    <iframe id="iframeModal" src="" width="100%" height="100%" frameborder="0"></iframe>
                </div>

                </div>
            </div>
        </div>
        
         <!-- The Modal -->
        <div class="modal" id="modalConfirma">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">¿Realmente deseas eliminar este criterio?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form class="form" id="formEditaCriterio" method="post" action="editarCriterio.php">
            <div class="modal-body">
                Si lo eliminas, se perderá también toda su escala de evaluación.
            </div>
            </form>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button></a>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="eliminaIndicador();">Sí, eliminar</button>
            </div>

            </div>
        </div>

    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>