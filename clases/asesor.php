<?php
	include_once("database.php");

	class asesor{
		public function getListaAsesores(){
            $query = "SELECT * FROM asesor ORDER BY apPaterno";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($asesor = $resultado->fetch_assoc()) {
                $lista[$i] = $asesor;
                $i++;
            }
            return $lista;
        }

        public function getBusquedaAsesores($busqueda){
            $query = "SELECT * FROM asesor WHERE apPaterno LIKE '%$busqueda%' OR apMaterno LIKE '%$busqueda%' OR nombres LIKE '%$busqueda%'";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($asesor = $resultado->fetch_assoc()) {
                $lista[$i] = $asesor;
                $i++;
            }
            return $lista;
        }

        public function getAsesor($rfc){
        	$query = "SELECT * FROM asesor WHERE rfc = '$rfc'";
            $resultado = query($query);
            $docente = $resultado->fetch_assoc();
            return $docente;
        }
	}	


?>