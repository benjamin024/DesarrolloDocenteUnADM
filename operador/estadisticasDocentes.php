<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/estadistica.php");
    $e = new estadistica;

    $datosEdos = $e->getDocentesPorEstado();
    $datosEstudios = $e->getEstudiosDocentes();
    $datosGeneros = $e->getGenerosDocentes();

    $arrayEdosAux = array();
    $maxNum = 0;
    foreach($datosEdos as $de){
        if($de["numero"] > $maxNum)
            $maxNum = $de["numero"];
        $arrayEdosAux[] = "{\"id\":\"".$de["estado"]."\", \"value\":".$de["numero"]."}";
    }

    $archivos = $e->getArchivos(1);
?>
<!DOCTYPE html>
<html>
<head>

    <!--Load the AJAX API-->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <!-- Include fusioncharts core library file -->
    <script type="text/javascript" src="../js/fusioncharts.js"></script>
    <!-- Include fusioncharts map definition files -->
    <script type="text/javascript" src="../js/fusioncharts.maps.js"></script>
    <script type="text/javascript" src="../js/fusioncharts.mexico.js"></script>
    <!-- Include fusioncharts jquery plugin -->
    <script type="text/javascript" src=" https://rawgit.com/fusioncharts/fusioncharts-jquery-plugin/develop/dist/fusioncharts.jqueryplugin.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

    $('document').ready(function () {
        $("#chart_div").insertFusionCharts({
            type: "maps/mexico",
            width: "800",
            height: "450",
            dataFormat: "json",
            dataSource: {
                "chart": {
                    "animation": "1",
                    "showCanvasBorder": false,
                    "borderAlpha":"30",
                    "nullEntityColor": "ffffff",
                    "usehovercolor": "1",
                    "caption": "Número de docentes por entidad federativa",
                    "hovercolor": "E3DCBE",
                    "decimals": "0"
                },
                "colorrange": {
                    "minvalue": "1",
                    "startlabel": "Mínimo",
                    "endlabel": "Máximo",
                    "code": "6baa01",
                    "gradient": "1",
                    "color": [{"maxvalue": "<?=$maxNum/8?>", "code": "f8bd19"}, {"maxvalue": "<?=$maxNum?>", "code": "ff0000"}]
                },
                "data": [<?=implode(",",$arrayEdosAux)?>],
            },
            "events": {
                "entityClick": function(evt, data) {
                    $.post("../clases/ajax.php", {ACCION: "docentesPorMunicipio", idEstado: data.id}, function(result){
                        alert(result);
                    });
                }
            }
                
        });
    });


     var data;
     var chart;

      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(graficaEstudios);
      google.charts.setOnLoadCallback(graficaGenero);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      

      function graficaEstudios() {

        // Create our data table.
        data = new google.visualization.arrayToDataTable([
            ['Grado máximo de estudios', 'Número de docentes'],
            <?php
                // query MySQL and put results into array $results
                $pLic = $datosEstudios["lic"]; // * 100 / $datosEstudios["total"];
                $pMc = $datosEstudios["mc"]; // * 100 / $datosEstudios["total"];
                $pDoc = $datosEstudios["doc"]; // * 100 / $datosEstudios["total"];
                $pOtros = $datosEstudios["otros"]; // * 100 / $datosEstudios["total"];
                echo "['Licenciatura', $pLic],";
                echo "['Maestría', $pMc],";
                echo "['Doctorado', $pDoc],";
                echo "['Sin especificar', $pOtros],";
            ?>
        ]);        

        // Set chart options
        var options = {'title':'Grado máximo de estudio de los docentes',
                       'fontSize': 12,
                       'width':800,
                       'height':500,
                       'animation':{
                           'startup': true,
                           'duration': 500
                       },
                       'is3D': true,
                       'titleTextStyle':{
                           'fontSize': 16,
                           'bold': true
                       },
                       'legend':{
                           'alignment': 'center'
                       }
                       };

        // Instantiate and draw our chart, passing in some options.
        chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        //google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(data, options);
      }

      function graficaGenero() {

        // Create our data table.
        data = new google.visualization.arrayToDataTable([
            ['Género de los docentes', 'Número de docentes'],
            <?php
                // query MySQL and put results into array $results
                $pH = $datosGeneros["hombres"];
                $pM = $datosGeneros["mujeres"];
                echo "['Hombres', $pH],";
                echo "['Mujeres', $pM]";
            ?>
        ]);        

        // Set chart options
        var options = {'title':'Género de los docentes de los docentes',
                       'fontSize': 12,
                       'width':800,
                       'height':500,
                       'animation':{
                           'startup': true,
                           'duration': 500
                       },
                       'is3D': true,
                       'titleTextStyle':{
                           'fontSize': 16,
                           'bold': true
                       },
                       'legend':{
                           'alignment': 'center'
                       }
                       };

        // Instantiate and draw our chart, passing in some options.
        chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
        //google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(data, options);
      }

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        var value = data.getValue(selectedItem.row, 0);
        alert('The user selected ' + value);
      }

      function abreModal(id){
        $('#modalConfirma').modal('toggle');
        $('#aEliminar').val(id);
      }
      
      function eliminarArchivo(){
            var id = $('#aEliminar').val();
            $.post("../clases/ajax.php", {ACCION: "eliminarArchivo", archivo: id}, function(result){
                if(result == "OK"){
                    location.reload();
                }
            });
      }

    </script>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>

                <div id="chart_div"style = " z_index: -10;"></div>
                <div id="chart_div2"style = " z_index: -10;"></div>
                <div id="chart_div3" style="margin-top:-100px; z_index: -10;"></div>
                <input type="hidden" id="aEliminar" value="">
                <?php
                    if($archivos){
                        echo "<center style='margin-top: -5px;'><h3>Numeralia</h3>";
                        foreach($archivos as $archivo){
                            switch($archivo["tipo"]){
                                case 1:
                                    echo "<img src='../img/estadisticas/1/".$archivo['nombre']."' width='100%'>";
                                    break;
                                case 2:
                                    echo "<iframe src='../img/estadisticas/1/".$archivo['nombre']."' width='100%' height='400px'></iframe>";
                                    break;
                                case 3:
                                    echo "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://desarrollodocente.com.mx/img/estadisticas/estadisticas/1/".$archivo['nombre']."' width='100%' height='400px' frameborder='0'></iframe>";
                            }
                            echo "<button type='button' class='btn btn-danger btn-sm' onclick=\"abreModal('".$archivo["id"]."');\">Eliminar archivo</button><br><br><br>";
                        }
                        echo "</center>";
                    }
                ?>
                <br>&nbsp;<br>&nbsp;<br>&nbsp;

                <!-- The Modal -->
                <div class="modal" id="modalConfirma">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">¿Estás seguro que deseas eliminar el archivo?</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            Si eliges eliminarlo, no habrá forma de recuperarlo después
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            
                            <button class="btn btn-success" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" onclick="eliminarArchivo();">Eliminar</button>
                        </div>

                        </div>
                    </div>
                </div>

    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-toggle.js"></script>
</body>
</html>