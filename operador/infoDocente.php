
<?php
    use Dompdf\Dompdf;
    require_once("../dompdf/autoload.inc.php");
    include("../clases/docente.php");
    $d = new docente;
    $docente = $d->getDocente($_GET["folio"]);

    $dompdf = new DOMPDF();
    $html = "<html><head></head>";
    $html .= "<body>";
    $html .= "<div><img src='../img/sep.png' height='50px'></div>";
    $html .= "<div style='position: absolute;  top: 0px; right: 0px;'><img src='../img/unadm.png' height='50px'></div>";
    //$html .= "<div style='position: absolute;  bottom: 0px; left: 0px; z-index: -999;'><img src='../img/Aguila.png'></div>";
    $html .= "<div style='background-color: #621132; margin-top: 20px; height: 25px; width: 100%;'></div>";
    $imagen = ($docente["img"])?"docentes/".$docente["folio"].".jpg":"defaultprofile.jpg";
    $html .= "<div style='margin-top: 25px; padding-top: 6px; width: 130px;'><img src='../img/".$imagen."' width='100%'></div>";
    $html .= "<div style='position: absolute; width: 570px; top: 120px; right: 0px;'><span style='font-size: 20px; font-weight: bold;'>Reporte de datos del docente</span>";
    $html .= "<br><br><table style='width: 100%; border-spacing: 0px; border-collapse: collapse; font-size: 13px;'>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #B38E5D; color: #FFF; padding-left: 50px; padding-right: 5px; font-size: 14px; font-weight: bold;'>Datos generales </td><td style='background-color: #B38E5D;'>&nbsp;</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Folio:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["folio"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>Apellido paterno:</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".$docente["apPaterno"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Apellido materno:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["apMaterno"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>Nombre(s):</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".$docente["nombres"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>RFC:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["rfc"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>CURP:</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".$docente["curp"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Lugar de nacimiento:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".query("SELECT estado FROM estado WHERE clave = '".substr($docente["curp"], 11, 2)."'")->fetch_assoc()["estado"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #B38E5D; color: #FFF; padding-left: 50px; padding-right: 5px; font-size: 14px; font-weight: bold;'>Datos de contacto </td><td style='background-color: #B38E5D;'>&nbsp;</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Estado de residencia:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["edo"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>Municipio de residencia:</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".query("SELECT municipio FROM municipio WHERE claveMun = ".$docente["mun"])->fetch_assoc()["municipio"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Teléfono de casa:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["tel"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>Teléfono celular:</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".$docente["cel"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Correo electrónico institucional:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["mailInst"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>Correo electrónico personal:</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".$docente["mailPers"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #B38E5D; color: #FFF; padding-left: 50px; padding-right: 5px; font-size: 14px; font-weight: bold;'>Formación académica</td><td style='background-color: #B38E5D;'>&nbsp;</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Licenciatura:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["lic"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>Maestría:</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".$docente["maestria"]."</td></tr>";
    $dip = ($docente["diplomado"])?"Sí":"No";
    $ind = ($docente["induccion"])?"Sí":"No";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Doctorado:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$docente["doc"]."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #FFFFFF; border-right: 1px solid #621132; padding-right: 5px;'>Curso de inducción UnADM:</td><td style='background-color: #FFFFFFF; padding-left: 5px;'>".$ind."</td></tr>";
    $html .= "<tr><td width='35%' style='padding: 4px; text-align: right; background-color: #F7F7F7; border-right: 1px solid #621132; padding-right: 5px;'>Diplomado de UnADM:</td><td style='background-color: #F7F7F7; padding-left: 5px;'>".$dip."</td></tr>";
    $html .= "</table>";
    $html .= "</div>";
    $html .= "</body></html>";
    
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream(
        "Reporte de datos del docente ".$_GET["folio"].".pdf",
        array(
            "Attachment" => false
        )
    );
?>
