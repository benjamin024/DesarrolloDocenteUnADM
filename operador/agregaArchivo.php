<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/estadistica.php");
    $e = new estadistica;
    
    $seccion =@$_POST["seccion"];
    $archivo = $_FILES["inputFile"];
    
    //print_r($archivo);

    //array de archivos disponibles 
    $archivos_disp_ar = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'ppt', 'pptx'); 
    //carpteta donde vamos a guardar la imagen 
    $carpeta = '../img/estadisticas/'.$seccion.'/'; 
    //guardamos el nombre original de la imagen en una variable 
    $nombrebre_orig = $archivo['name']; 
    
    //el proximo codigo es para ver que extension es la imagen 
    $array_nombre = explode('.',$nombrebre_orig); 
    $cuenta_arr_nombre = count($array_nombre); 
    $extension = strtolower($array_nombre[--$cuenta_arr_nombre]); 

    //validamos la extension 
    if(in_array($extension, $archivos_disp_ar)){
        $archivoUpload = $carpeta.$nombrebre_orig;
        if(move_uploaded_file($archivo["tmp_name"] , $archivoUpload)){
            chmod($archivoUpload, 0755);
            switch($extension){
                case "jpg":
                case "jpeg":
                case "png":
                    $tipo = 1;
                    break;
                case "pdf":
                    $tipo = 2;
                    break;
                default:
                    $tipo = 3;
            }
            $e->registraArchivo($nombrebre_orig, $seccion, $tipo);
            header("location: estadisticas.php");
        }else{
            echo "ERROR :C";
        }
    }else{
        echo "MAL EXTENSIÓN";
    }

?>