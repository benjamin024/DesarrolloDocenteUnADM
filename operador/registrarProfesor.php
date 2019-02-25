<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    include("../clases/docente.php");
    $folio = $_POST["folio"];
    $d = new docente();
    if($d->estaRegistrado($folio) == 0){ //No existe ese folio registrado en la base de datos
        $aP = $_POST["apPaterno"];
        $aM = $_POST["apMaterno"];
        $nombre = $_POST["nombre"];
        $rfc = $_POST["rfc"];
        $curp = $_POST["curp"];
        $edo = $_POST["estado"];
        $mun = $_POST["municipio"];
        $tel = $_POST["tel"];
        $cel = $_POST["cel"];
        $mailI = $_POST["mailInst"];
        $mailP = $_POST["mailPers"];
        $lic = $_POST["lic"];
        $mc = $_POST["maestria"];
        $doc = $_POST["doc"];
        $ind = @$_POST["induccion"];
        $dip = @$_POST["diplomado"];
        $img = $_FILES["img"];

        if($ind)
            $ind = 1;
        else
            $ind = 0;
        if($dip)
            $dip = 1;
        else 
            $dip = 0;
        if($img)
            $imgDB = 1;
        else 
            $imgDB = 0;

        $registro = $d->addDocente($folio, $aP, $aM, $nombre, $rfc, $curp, $edo, $mun, $tel, $cel, $mailI, $mailP, $lic, $mc, $doc, $ind, $dip, $imgDB);
        
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
        if($registro){
            header('location: fichaProfesor.php?folio='.$folio.'&msg=OK');
        }else{
            header('location: form_registrarProfesor.php?msg=ERROR');
        }
    }else{
        header('location: fichaProfesor.php?folio='.$folio.'&msg=FOLIO');
    }
    
?>