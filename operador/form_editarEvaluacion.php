<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();
    $idEvaluacion =@$_GET["evaluacion"];
    $evaluaciones = $e->getListaEvaluaciones();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Editar evaluación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <script>
        var rG, idG;

        function eliminaCriterio(){
            
            $.post("eliminaCriterio.php", {idCriterio: idG}, function(result){
                if(result == 1){
                    var i = rG.parentNode.parentNode.rowIndex;
                    document.getElementById("criteriosTabla").deleteRow(i);
                    document.getElementById("numCriterios").value = document.getElementById("numCriterios").value - 1;
                }else{
                    console.log("no se eliminó!");
                }
            });
        }

        function abreModal(id, criterio, porcentaje){
            document.getElementById("inputCriterio").value = criterio;
            document.getElementById("inputPorcentaje").value = porcentaje;
            document.getElementById("inputId").value = id;
            document.getElementById("linkEditaIndicadores").setAttribute("href","form_editarIndicador.php?idCriterio="+id+"&criterio="+criterio);
            $('#modalCriterio').modal('toggle')
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
                    <button class="btn btn-success" onclick="document.getElementById('formEvaluacion').submit();">Guardar cambios</button>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%;">
                <center>
                    <br><h4>Editar <?=@$_GET["nombre"]?></h4><br>                    
                </center>
                <div class="row">
                        <form id="formEvaluacion" method="post" action="editarEvaluacion.php">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td width="10%" class="bg-successM align-middle" style="text-align: center;"><b>Nombre:</b></td>
                                <td width="60%"><input name="nombre" type="text" class="form-control" value="<?=@$_GET['nombre']?>"></td>
                                <td width="15%" class="bg-successM align-middle"  style="text-align: center;"><b>Porcentaje (%):</b></td>
                                <td width="15%"><input name="porcentaje" type="number" class="form-control" value="<?=@$_GET['porcentaje']?>"></td>
                            </tr>
                        </table>
                        <input type="hidden" name="idEvaluacion" value="<?=@$_GET["idEvaluacion"]?>">
                        </form>
                        <table id="criteriosTabla" class="table table-bordered table-sm " style="margin-top: -1.1em;">
                            <tr>
                                <td width="60%" class="bg-successM align-middle" style="text-align: center;"><b>Criterio</b></td>
                                <td width="20%" class="bg-successM align-middle" style="text-align: center;"><b>Porcentaje (%)</b></td>
                                <td width="20%" class="bg-successM align-middle" style="text-align: center;"><b>Opciones</b></td>
                            </tr>
                            <?php
                                $criterios = $e->getCriterios(@$_GET["idEvaluacion"]);
                                $i = 0;
                                foreach($criterios as $criterio){
                                    $i++;
                            ?>
                                <tr>
                                    <td><?=$criterio['nombre']?></td>
                                    <td><?=$criterio['porcentaje']?></td>
                                    <td style="text-align: center;"><button class="btn btn-success" onclick="abreModal(<?=$criterio['idCriterio']?>,'<?=$criterio['nombre']?>','<?=$criterio['porcentaje']?>');">Editar</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-danger" onclick="confirmaEliminar(this,'<?=$criterio["idCriterio"]?>')">Eliminar</button></td>
                                </tr>
                            <?php
                                }
                            ?>
                            <input type="hidden" name="numCriterios" id="numCriterios" value="<?=$i?>">
                            <tr>
                                <td colspan="3" style="text-align: center;"><button class="btn btn-success" onclick="$('#modalNuevoCriterio').modal('toggle')">Agregar criterio</button></td>
                            </tr>
                        </table>
                </div>
                
                <!---->
                
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal" id="modalNuevoCriterio">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo criterio</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form class="form" id="formAgregaCriterio" method="post" action="agregarCriterio.php">
                <div class="modal-body row">
                
                    <div class="col-md-8">
                        <label for="pwd">Criterio:</label>
                        <input type="text" class="form-control" id="inputCriterioN" name="inputCriterio">
                    </div>
                    <div class="col-md-4">
                        <label for="pwd">Porcentaje (%):</label>
                        <input type="number" class="form-control" id="inputPorcentajeN" name="inputPorcentaje">
                    </div>
                    <input type="hidden" name="idEvaluacion" value="<?=@$_GET["idEvaluacion"]?>"> 
                    <input type="hidden" name="nombre" value="<?=@$_GET["nombre"]?>">
                    <input type="hidden" name="porcentaje" value="<?=@$_GET["porcentaje"]?>">      
                </div>
                </form>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="document.getElementById('formAgregaCriterio').submit();">Agregar criterio</button>
                </div>

                </div>
            </div>
        </div>



        <!-- The Modal -->
        <div class="modal" id="modalCriterio">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Editar criterio</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form class="form" id="formEditaCriterio" method="post" action="editarCriterio.php">
                <div class="modal-body row">
                
                    <div class="col-md-8">
                        <label for="pwd">Criterio:</label>
                        <input type="text" class="form-control" id="inputCriterio" name="inputCriterio">
                    </div>
                    <div class="col-md-4">
                        <label for="pwd">Porcentaje (%):</label>
                        <input type="number" class="form-control" id="inputPorcentaje" name="inputPorcentaje">
                    </div>
                    <input type="hidden" name="inputId" id="inputId">
                    <input type="hidden" name="idEvaluacion" value="<?=@$_GET["idEvaluacion"]?>">
                    <input type="hidden" name="nombre" value="<?=@$_GET["nombre"]?>">
                    <input type="hidden" name="porcentaje" value="<?=@$_GET["porcentaje"]?>">        
                </div>
                </form>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="" id="linkEditaIndicadores"><button type="button" class="btn btn-success">Editar indicadores</button></a>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="document.getElementById('formEditaCriterio').submit();">Guardar cambios</button>
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
                    Si lo eliminas, se perderán también todos los indicadores asociados a este criterio.
                </div>
                </form>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button></a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="eliminaCriterio();">Sí, eliminar</button>
                </div>

                </div>
            </div>
        </div>

    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>