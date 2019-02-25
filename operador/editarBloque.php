<?php
    session_start();
    if($_SESSION["usuario_UnADM"] == "")
        header("location: ../index.php");
    require("../clases/ajuste.php");

    $a = new ajuste();
    
    $id =@$_POST["id"];
    $titulo =@$_POST["titulo"];
    $color =@$_POST["color"];
    $fuente =(@$_POST["fuente"]) ? 1 : 0;
    $link =@$_POST["link"];
    $archivo = $_FILES["inputFile"];

    if($archivo["size"] > 0){
    //array de archivos disponibles 
    $archivos_disp_ar = array('jpg', 'jpeg', 'png'); 
    //carpteta donde vamos a guardar la imagen 
    $carpeta = '../img/ajustes/docentes/'; 
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
            $a->editarBloque($id, $titulo, $nombrebre_orig, $color, $fuente, $link);
            header("location: confInicioDocentes.php");
        }else{
            echo "ERROR :C";
        }
    }else{
        echo "MAL EXTENSIÓN";
    }
    }else{
        $a->editarBloque($id, $titulo, @$_POST["nombreImagen"], $color, $fuente, $link);
        header("location: confInicioDocentes.php");
    }

?>