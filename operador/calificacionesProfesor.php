<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    require("../clases/docente.php");
    $folio = (@$_GET["folio"]) ? @$_GET["folio"] : $_SESSION["usuario_UnADM"];
	//$folio =@$_GET["folio"];
    $e = new evaluacion();
    $d = new docente();
    $evaluaciones = $e->getListaEvaluaciones();
    $docente = $d->getDocente($folio);
	$mensajeEvaluacion;
	$mensajeEvaluacionFinal;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></title>
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
            if($_SESSION["tipo"] == 0){
                include("../navbar.html");
                $folder = "";
            }
            else if($_SESSION["tipo"] == 1){
                $folder = "../docente/";
                include("../navbar-d.html");
            }else{
                $folder = "../asesor/";
                include("../navbar-a.html");
            }
        ?>
        <div class="row aguila"  style="position: absolute; top: 0px; padding-top: 126px; width: 100%; z-index: -1; height:100%; margin: 0px;  justify-content: center;">
            <div class="col-md-2 align-items-center" style="">
                <br>
                <center id='latmenu'>
                    <a href="<?=$folder?>fichaProfesor.php?folio=<?=$folio?>" class="boton"><button class="btn btn-success">Regresar</button></a><br><br>
                </center>
            </div>
            <div class="col-md-10 align-items-center" style="padding: 0 5%;">
                <center>
                    <br><h4><?=$docente["nombres"]." ".$docente["apPaterno"]." ".$docente["apMaterno"]?></h4><br>                    
                </center>
                <?php
                    $calificaciones = $e->getIndicadorCalificacion($folio);
					//print_r($calificaciones);
					if($calificaciones){
					?>
						
						<table class="table table-bordered table-sm table-responsive">
							<thead class="bg-successM" style="text-align: center;">
								<tr>
									<th rowspan="2" class="align-middle">Periodo</th>
									<th rowspan="2" class="align-middle">Planeación Didáctica</th>
									<th rowspan="2" class="align-middle">Comunicación</th>
									<th rowspan="2" class="align-middle">Uso y manejo de las herramientas del aula virtual</th>
									<th rowspan="2" class="align-middle">Actividades Didácticas</th>
									<th rowspan="2" class="align-middle">Retroalimentación</th>
									<th rowspan="2" class="align-middle">Estrategias de retención y recuperación de estudiantes</th>
									<th rowspan="2" class="align-middle">Valoración Final</th>
								</tr>
							</thead>
							<tbody style="text-align: center;" >
								<tr>
								
									<td class='align-middle'><a href='resumenEvaluacion.php?evaluacion=<?=$calificaciones[0]["idEvaluacion"]?>'><?=$calificaciones[0]["periodo"]?></a></td>
									<?php
										foreach($calificaciones as $calificacion){
											if ($calificacion["calificacion"] >= 9){
												$mensajeEvaluacion = 'Muy Bien';
											}
									
											elseif (($calificacion["calificacion"] >= 8 ) && ($calificacion["calificacion"] < 9 )) {
												$mensajeEvaluacion = 'Bien';								
											}
							
											elseif (($calificacion["calificacion"]  >= 7) && ($calificacion["calificacion"] < 8 )) {
												$mensajeEvaluacion = 'Regular';								
											}
							
											elseif ($calificacion["calificacion"] < 7) {
												$mensajeEvaluacion = 'Necesita Mejorar';								
											}
							
											if(is_numeric($calificacion["calificacion"]))
												echo "<td class='align-middle'>".$mensajeEvaluacion."</td>";
											else
												echo "<td class='align-middle'>".$mensajeEvaluacion."</td>";
										?>
									<?php
										}
									
										if ($calificaciones[0]["final"] >= 9){
											$mensajeEvaluacionFinal = 'Muy Bien';
										}
								
										elseif (($calificaciones[0]["final"]>= 8 ) && ($calificaciones[0]["final"] < 9 )) {
											$mensajeEvaluacionFinal = 'Bien';								
										}
						
										elseif (($calificaciones[0]["final"] >= 7) && ($calificaciones[0]["final"] < 8 )) {
											$mensajeEvaluacionFinal = 'Regular';								
										}
						
										elseif ($calificaciones[0]["final"] < 7) {
											$mensajeEvaluacionFinal = 'Necesita Mejorar';								
										}
									?>	
									<td class='align-middle'><b><?=$mensajeEvaluacionFinal?></b></td>
								</tr>
							 </tbody>
						<?php
                    }
					
					else{
                        echo "<center><h5>No hay registros para este docente</h5></center>";
                    }
                ?>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>