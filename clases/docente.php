<?php

    include_once("database.php");

    class docente{
        
        public function getDocente($folio){
            $query = "SELECT d.*, e.estado as edo, m.municipio FROM docente d LEFT JOIN estado e ON d.estado = e.clave LEFT JOIN municipio m ON d.mun = m.claveMun WHERE d.folio = '$folio';";
            $resultado = query($query);
            $docente = $resultado->fetch_assoc();
            return $docente;
        }

        public function getListaDocentes($asesor = ''){
            $query = "SELECT * FROM docente WHERE estadoLogico != 0 ORDER BY apPaterno";
            if($asesor)
                $query = "SELECT * FROM docente WHERE estadoLogico != 0 AND asesor = '$asesor' ORDER BY apPaterno";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($docente = $resultado->fetch_assoc()) {
                $lista[$i] = $docente;
                $i++;
            }
            return $lista;
        }

        public function estaRegistrado($folio){
            $query = "SELECT count(*) as num FROM docente WHERE folio = '$folio';";
            $resultado = query($query);
            return $resultado->fetch_assoc()["num"];
        }

        public function addDocente($folio, $aP, $aM, $nombre, $rfc, $curp, $edo, $mun, $tel, $cel, $mailI, $mailP, $lic, $mc, $doc, $ind, $dip, $img){
            $query = "INSERT INTO docente(folio, apPaterno, apMaterno, nombres, fechaReg, rfc, curp, estado, mun, tel, cel, mailInst, mailPers, lic, maestria, doc, induccion, diplomado, img) VALUES('$folio', '$aP', '$aM', '$nombre', NOW(), '$rfc', '$curp', '$edo', '$mun', '$tel', '$cel', '$mailI', '$mailP', '$lic', '$mc', '$doc', $ind, $dip, $img);";
            $alta = query($query);
            return $alta;
        }

        public function updateDocente($folio, $folioA, $aP, $aM, $nombre, $rfc, $curp, $edo, $mun, $tel, $cel, $mailI, $mailP, $lic, $mc, $doc, $ind, $dip, $imgDB, $f){
            $query =  "UPDATE docente SET folio = '$folio', folioA = '$folioA', apPaterno = '$aP', apMaterno = '$aM', nombres = '$nombre', rfc = '$rfc', curp = '$curp', estado = '$edo', mun = '$mun', tel = '$tel', cel = '$cel', mailInst = '$mailI', mailPers = '$mailP', lic = '$lic', maestria = '$mc', doc = '$doc', induccion = '$ind', diplomado = '$dip', img = '$imgDB' WHERE folio = '$f'; ";
            $update = query($query);
            return $update;
        }

        public function getBusquedaDocentes($busqueda){
            $query = "SELECT * FROM docente WHERE apPaterno LIKE '%$busqueda%' OR apMaterno LIKE '%$busqueda%' OR nombres LIKE '%$busqueda%'";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($docente = $resultado->fetch_assoc()) {
                $lista[$i] = $docente;
                $i++;
            }
            return $lista;
        }
    }
?>