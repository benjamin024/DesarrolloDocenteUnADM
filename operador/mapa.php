<?php

require("../clases/estadistica.php");
    $e = new estadistica;

$datosEdos = $e->getDocentesFiltro(@$_GET["filtro"]);

$arrayEdosAux = array();
$maxNum = 0;
foreach($datosEdos as $de){
    if($de["numero"] > $maxNum)
        $maxNum = $de["numero"];
    $arrayEdosAux[] = "{\"id\":\"".$de["estado"]."\", \"value\":".$de["numero"]."}";
}

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
            width: "1000",
            height: "510",
            dataFormat: "json",
            dataSource: {
                "chart": {
                    "animation": "1",
                    "showCanvasBorder": false,
                    "borderAlpha":"30",
                    "nullEntityColor": "ffffff",
                    "usehovercolor": "1",
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

      function abreModal(id){
        $('#modalConfirma').modal('toggle');
        $('#aEliminar').val(id);
      }
      

    </script>

    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>

    <div id="chart_div"style = " z_index: -10;"></div>

    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-toggle.js"></script>
</body>
</html>