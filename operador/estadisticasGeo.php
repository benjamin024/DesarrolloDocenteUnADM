<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    ?>
<!DOCTYPE html>
<html>
<head>
	<title>Estadísticas geográficas</title>
    <!--Load the AJAX API-->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Include fusioncharts core library file -->
    <script type="text/javascript" src="../js/fusioncharts.js"></script>
    <!-- Include fusioncharts map definition files -->
    <script type="text/javascript" src="../js/fusioncharts.maps.js"></script>
    <script type="text/javascript" src="../js/fusioncharts.mexico.js"></script>
    <!-- Include fusioncharts jquery plugin -->
    <script type="text/javascript" src=" https://rawgit.com/fusioncharts/fusioncharts-jquery-plugin/develop/dist/fusioncharts.jqueryplugin.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <style type="text/css">
    	.modal, .modal-backdrop {
		    position: absolute !important;
		}
    </style>
    <script type="text/javascript">
    	var filtro = [];

    	function getIndexOf(arreglo, elemento){
    		for(i = 0; i < arreglo.length; i++){
    			if(arreglo[i] == elemento)
    				return i;
    		}
    	}

    	function limpiaFiltro(arreglo){
    		var genero = 0;
    		var edad = 0;
    		var nivelEstudios = 0;
    		var area = 0;

    		$('.form-check-input').each(function(){
    			switch($(this).data('seccion')){
    				case "genero":
    					if($(this)[0].checked)
    						genero++;
    					break;
    				case "nivelEstudios":
    					if($(this)[0].checked)
    						nivelEstudios++;
    					break;
    			}
    		});

    		if(genero == 2){
    			arreglo.splice(getIndexOf(arreglo, "SUBSTR(d.curp, 11, 1) = 'H'", 1));
    			arreglo.splice(getIndexOf(arreglo, "SUBSTR(d.curp, 11, 1) = 'M'", 1));
    			arreglo.push("SUBSTR(d.curp, 11, 1) = 'H' OR SUBSTR(d.curp, 11, 1) = 'M'");
    		}

    		if(nivelEstudios == 3){

    		}
			console.log(genero);
			console.log(nivelEstudios);

			return arreglo;	
    	}

    $('document').ready(function () {
             
          $("#modalIni").modal("show");
       
          //appending modal background inside the blue div
          $('.modal-backdrop').appendTo('.mapaMx');   
     
          //remove the padding right and modal-open class from the body tag which bootstrap adds when a modal is shown
          $('body').removeClass("modal-open")
          $('body').css("padding-right",""); 

          var filtroGenero = [];
          var filtroEdad = [];
          var filtroEstudios = [];
          var filtroArea = []; 

          $('.form-check-input').each(function(){
		        $(this).change(function(){
		        	var fa = "";
		        	switch($(this).data('seccion')){
	    				case "genero":
	    					if($(this)[0].checked){
				            	if($(this).data("sql"))
				            		filtroGenero.push($(this).data("sql"));
				            }else{
				            	filtroGenero.splice(getIndexOf(filtroGenero, $(this).data("sql")), 1); 
				            }
	    					break;
	    				case "edad":
	    					console.log(whereFiltro);
		        			$('#iframeMapa').attr("src", "mapa.php?filtro="+whereFiltro);
	    					break;
	    				case "nivelEstudios":
	    					if($(this)[0].checked){
				            	if($(this).data("sql"))
				            		filtroEstudios.push($(this).data("sql"));
				            }else{
				            	filtroEstudios.splice(getIndexOf(filtroEstudios, $(this).data("sql")), 1); 
				            }
	    					break;
	    			}

		            var auxFiltro = [];
		            if(filtroGenero.length)
		            	auxFiltro.push("(" + filtroGenero.join(" OR ") + ")");
		            if(filtroEstudios.length)
		            	auxFiltro.push("(" + filtroEstudios.join(" OR ") + ")");
		            if(filtroArea.length)
		            	auxFiltro.push("(" + filtroArea.join(" OR ") + ")");

		        	var whereFiltro = auxFiltro.join(" AND ");
		        	console.log(whereFiltro);
		        	$('#iframeMapa').attr("src", "mapa.php?filtro="+whereFiltro);
		        });
		    });   

        
    });
</script>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
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
            <div class="col-md-3 align-items-center" style="overflow-y: scroll !important;">
                <br>
                <center id='latmenu'>
                    <a href="estadisticas.php" class="boton"><button class="btn btn-success">Regresar</button></a>
                    <hr>
                </center>
                <b>Filtros:</b>
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Género:</label>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" data-seccion="genero" data-sql="SUBSTR(d.curp, 11, 1) = 'H'" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Masculino
							</label>
						</div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" data-seccion="genero" data-sql="SUBSTR(d.curp, 11, 1) = 'M'" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Femenino
							</label>
						</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Edad:</label>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								De 18 a 30 años
							</label>
						</div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								De 31 a 49 años
							</label>
						</div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Mayores de 50 años
							</label>
						</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Nivel de estudios:</label>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" data-seccion="nivelEstudios" data-sql="(maestria = '' AND doc = '')" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Licenciatura
							</label>
						</div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" data-seccion="nivelEstudios" data-sql="(maestria != '' AND doc = '')"  id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Maestría
							</label>
						</div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" data-seccion="nivelEstudios" data-sql="(doc != '')"  id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Doctorado
							</label>
						</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Área de conocimiento:</label>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Ciencias exactas
							</label>
						</div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Ciencias biológicas y de la salud
							</label>
						</div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 35px">
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
							<label class="form-check-label" for="defaultCheck1">
								Ciencias sociales y administrativas
							</label>
						</div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 align-items-center mapaMx" style="padding: 0; position: relative; overflow-y: auto;">
            	<iframe name="iframeMapa" id="iframeMapa" src="mapa.php" width="100%" height="100%" frameborder="0"></iframe>
                <!-- The Modal -->
		        <div class="modal fade" id="modalIni">
		            <div class="modal-dialog">
		                <div class="modal-content">

		                <!-- Modal Header -->
		                <div class="modal-header">
		                    <h4 class="modal-title">Filtros de búsqueda necesarios</h4>
		                    <button type="button" class="close" data-dismiss="modal">&times;</button>
		                </div>

		                <!-- Modal body -->
		                <div class="modal-body">
		                    Selecciona los filtros de búsqueda correspondientes de acuerdo a la información que desees consultar
		                </div>

		                <!-- Modal footer -->
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
		                </div>

		                </div>
		            </div>
		        </div>
            </div>
        </div>
    </div>
</body>
</html>