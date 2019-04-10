<?php
    include_once("database.php");
    include_once("evaluacion.php");
    include_once("estadistica.php");

    $ACCION = @$_POST["ACCION"];

    if($ACCION == "cargaSelectMunicipios"){
        $estado = @$_POST["estado"];
        $query = "SELECT * FROM municipio WHERE estado = '$estado'";
        $resultado = query($query);
            $municipios = "";
            while ($municipio = $resultado->fetch_assoc()) {
                $municipios .= $municipio["claveMun"]."-".$municipio["municipio"]."--";
            }
        echo $municipios;
        exit(1);
    }

    if($ACCION == "evaluacionesDisponibles"){
        $e = new evaluacion;
        $evaluaciones = "";
        $evaluacion =@$_POST["evaluacion"];
        $docente =@$_POST["docente"];
        $listaE = $e->getEvaluacionesDisponibles($evaluacion, $docente);
        foreach($listaE as $evaluacion){
            $evaluaciones .= "$evaluacion--";
        }
        echo $evaluaciones;
        exit(1);
    }

    if($ACCION == "limpiaEvaluacion"){
        $e = new evaluacion;
        $result = $e->limpiaEvaluacion($_POST["evaluacion"]);
        if($result)
            echo "OK";
        exit(1);
    }

    if($ACCION == "eliminarArchivo"){
        $e = new evaluacion;
        $result = $e->eliminarArchivo($_POST["archivo"]);
        if($result)
            echo "OK";
        exit(1);
    }

    if($ACCION == "docentesPorMunicipio"){
        $estado = query("SELECT * FROM estado WHERE idMap = ".$_POST["idEstado"])->fetch_assoc();
        $numDocentesEdo = query("SELECT count(*) AS num FROM docente WHERE estado = '".$estado["clave"]."'")->fetch_assoc()["num"];
        if($numDocentesEdo){
            $result = "De los $numDocentesEdo docentes que viven en ".$estado["estado"].":\n";
            $municipios = query("SELECT * FROM municipio WHERE estado = '".$estado["clave"]."'");
            while($municipio = $municipios->fetch_assoc()){
                $numDocentesMun = query("SELECT count(*) AS num FROM docente WHERE mun = ".$municipio["claveMun"])->fetch_assoc()["num"];
                if($numDocentesMun){
                    if($numDocentesMun > 1)
                        $texto = "encuentran";
                    else  
                        $texto = "encuentra";
                    $result .= "\t• $numDocentesMun se $texto en ".$municipio["municipio"]."\n";
                }
            }
        }else
            $result = "No hay docentes en ".$estado["estado"];
        
        echo $result;
        exit(1);
    }

    if($ACCION == "cambiaPswDocente"){
        $folio =@$_POST["folio"];
        $pass =@$_POST["pass"];
        $qr = "UPDATE docente SET password = SHA1('$pass'), flagPsw = 0 WHERE folio = '$folio'";
        echo query($qr);
        exit(1);
    }

    if($ACCION == "noRecordarPswDocente"){
        $folio =@$_POST["folio"];
        $qr = "UPDATE docente SET flagPsw = 0 WHERE folio = '$folio'";
        echo query($qr);
        exit(1);
    }

    if($ACCION == "cambiaFiltro"){
        $filtro =@$_POST["filtro"];
        $e = new estadistica;
        $datosEdos = $e->getDocentesFiltro($filtro);
        $arrayEdosAux = array();
        $maxNum = 0;
        foreach($datosEdos as $de){
            if($de["numero"] > $maxNum)
                $maxNum = $de["numero"];
            $arrayEdosAux[] = "{\"id\":\"".$de["estado"]."\", \"value\":".$de["numero"]."}";
        }
        echo "[".implode(",",$arrayEdosAux)."]";
        exit(1);
    }

    if($ACCION == "getIdEvaluacionDocente"){
        $e = new evaluacion;
        $evaluacion =@$_POST["evaluacion"];
        $periodo =@$_POST["periodo"];
        $docente =@$_POST["docente"];
        $id = $e->getIdEvaluacionDocente($evaluacion, $periodo, $docente);
        echo $id;
        exit(1);
    }

    if($ACCION == "guardarImagen"){
        $data = $_POST["imagen"];
        $nombre = $_POST["nombre"];
        $url = $_POST["url"];
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                echo -1;
                exit(1);
            }

            $data = base64_decode($data);

            if ($data === false) {
                echo -2;
                exit(1);
            }
        } else {
            echo -3;
            exit(1);
        }

        file_put_contents("{$url}{$nombre}.{$type}", $data);
        echo 1;
        exit(1);
    }
?>