<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/evaluacion.php");
    $e = new evaluacion();
    
    $idIndicador =@$_POST["idIndicador"];
    $titulo =@$_POST["nombre"];
    $mensaje =@$_POST["mensaje"];
    $diez =@$_POST["eval10"];
    $ocho =@$_POST["eval8"];
    $seis =@$_POST["eval6"];
    $tres =@$_POST["eval3"];
    $idC =@$_POST["idCriterio"];
    $nombreC =@$_POST["criterio"];

    $e->addIndicador($idC, $titulo, $mensaje, $diez, $ocho, $seis, $tres);

    header("location: form_editarIndicador.php?idCriterio=$idC&criterio=$nombreC");
    
?>