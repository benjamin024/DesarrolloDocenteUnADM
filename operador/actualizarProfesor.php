<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    include("../clases/docente.php");

    $folio = $_POST["folio"];
    $aP = $_POST["aP"];
    $aM = $_POST["aM"];
    $nombre = $_POST["nombre"];
    $rfc = $_POST["rfc"];
    $curp = $_POST["curp"];
    $edo = $_POST["estado"];
    $mun = $_POST["mun"];
    $tel = $_POST["tel"];
    $cel = $_POST["cel"];
    $mailI = $_POST["mailI"];
    $mailP = $_POST["mailP"];
    $lic = $_POST["lic"];
    $mc = $_POST["mc"];
    $doc = $_POST["doc"];
    $ind = @$_POST["ind"];
    $dip = @$_POST["dip"];
    
    if($folio != $_POST["folioAux"]){
        $folioA = $_POST["folioAux"];
    }else{
        $folioA = "";
    }

    if($ind)
        $ind = 1;
    else
        $ind = 0;
    if($dip)
        $dip = 1;
    else 
        $dip = 0;
    if($_POST["imgAux"] == "selected" || $_POST["imgAux"] == "changed")
        $imgDB = 1;
    else 
        $imgDB = 0;

    if($_POST["imgAux"] == "changed")
        $img = $_FILES["img"];
    else{
        $img = 0;
    }

    $d = new docente();

    if($folioA == "" || $d->estaRegistrado($folio) == 0){
        $f = ($folioA == "")?$folio:$folioA;
        $actualizacion = $d->updateDocente($folio, $folioA, $aP, $aM, $nombre, $rfc, $curp, $edo, $mun, $tel, $cel, $mailI, $mailP, $lic, $mc, $doc, $ind, $dip, $imgDB, $f);
        if($img){
            //array de archivos disponibles 
            $archivos_disp_ar = array('jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff', 'bmp'); 
            //carpteta donde vamos a guardar la imagen 
            $carpeta = '../img/docentes/'; 
            //guardamos el nombre original de la imagen en una variable 
            $nombrebre_orig = $img['name']; 
            
            //el proximo codigo es para ver que extension es la imagen 
            $array_nombre = explode('.',$nombrebre_orig); 
            $cuenta_arr_nombre = count($array_nombre); 
            $extension = strtolower($array_nombre[--$cuenta_arr_nombre]); 

            //validamos la extension 
            if(in_array($extension, $archivos_disp_ar)){
                $archivo = $carpeta.$folio.".jpg";
                if(move_uploaded_file($img["tmp_name"] , $archivo)){
                    chmod($archivo, 0755);
                }else{
                    $origen = "../img/defaultprofile.jpg";
                    copy($origen, $carpeta.$folio.".jpg");
                }
            }else{
                $origen = "../img/defaultprofile.jpg";
                copy($origen, $carpeta.$folio.".jpg");
            }
        }
        if($actualizacion){
            header('location: form_actualizarProfesor.php?msg=OK&folio='.$folio);
        }else{
            header('location: form_actualizarProfesor.php?msg=ErrorAct');
        }
    }else {
        header('location: form_actualizarProfesor.php?folio='.$folioA.'&msg=ErrorFolio&folioA='.$folio);
    }

?>