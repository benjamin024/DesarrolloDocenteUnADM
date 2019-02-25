<script>
    alert("HOLA MUNDO");
</script>
<?php
    use Dompdf\Dompdf;
    require_once("../dompdf/autoload.inc.php");
    
    require("../clases/evaluacion.php");
    require("../clases/docente.php");

    $idEvaluacionDocente =@$_GET["evaluacion"];

    $e = new evaluacion();
    $d = new docente();

    $infoED = query("SELECT * FROM evaluacionDocente WHERE idEvaluacionDocente = $idEvaluacionDocente")->fetch_assoc();
    $folio = $infoED["docente"];
    $docente = $d->getDocente($folio);
    $evaluacionBD = query("SELECT * FROM evaluacion WHERE idEvaluacion = (SELECT evaluacion FROM evaluacionDocente WHERE idEvaluacionDocente = $idEvaluacionDocente)")->fetch_assoc();
    $periodo = $infoED["periodo"];
    $observaciones = $e->getObservacionesEvaluacion($idEvaluacionDocente);
    $comentarios = $infoED["comentario"];
    $calificacionFinal = $infoED["calificacion"];

    $dompdf = new DOMPDF();
    $html = "<html><head><style>@page {
        margin: 35px 70px;
    }</style>
    </head>";
    $html .= "<body>";
    $html .= "<div><img src='../img/sep.png' height='50px'></div>";
    $html .= "<div style='position: absolute;  top: 0px; right: 0px;'><img src='../img/unadm.png' height='50px'></div>";
    $html .= "<div style='background-color: #373C42; margin-top: 20px; height: 25px; width: 100%;'></div>";
    $html .= "<center><br><h3>Resumen de resultados de la ".$evaluacionBD["nombre"]."</h3><br></center>";
    $html .= "<p style='text-align: justify;'>La UnADM realiza la evaluación del desempeño de las funciones sustantivas de los docentes con el objetivo de coadyuvar a la mejora de la práctica educativa y de elevar la calidad del servicio que ofrece a sus estudiantes.</p>";
    $html .= "<p style='text-align: justify;'>Actualmente el proceso considera hasta el momento tres fuentes de información: asesores académicos, estudiantes y una autoevaluación de los mismos docentes. Los resultados permiten conocer las áreas de oportunidad que se deben atender, ya que nuestra evaluación tiene un sentido formativo, sumativo y holístico, ello nos permite que después del análisis de resultados, se logre mejorar el nivel de cumplimiento de sus funciones.</p>";
    $html .= "<div id='graficaEvaluacion'></div>";
    $html .= "</body></html>";
    echo $html;
    exit(1);
    $dompdf->load_html($html);
	$dompdf->render();
    $dompdf->stream(
        "Resumen de evaluación.pdf",
        array(
            "Attachment" => false
        )
    );
?>