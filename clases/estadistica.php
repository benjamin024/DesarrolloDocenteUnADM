<?php
    include_once("database.php");

    class estadistica{
        public function getDocentesPorEstado(){
            $datos = array();
            $query = "SELECT * FROM estado ORDER BY idMap";
            $resultado = query($query);
            while($estado = $resultado->fetch_assoc()){
                $query = "SELECT count(*) as numero FROM docente WHERE estado = '".$estado["clave"]."'";
                $res = query($query);
                $dato["estado"] = $estado["idMap"];
                while($num = $res->fetch_assoc()){
                    $dato["numero"] = $num["numero"];
                }
                $datos[] = $dato;
            }
            return $datos;
        }

        public function getEstudiosDocentes(){
            $datos = array();
            $query = "SELECT count(*) as lic FROM docente WHERE (lic != '' OR lic != NULL) AND (maestria  = '' OR maestria = NULL) AND (doc = '' OR doc = NULL)";
            $datos["lic"] = query($query)->fetch_assoc()["lic"];
            $query = "SELECT count(*) as mc FROM docente WHERE (maestria  != '' OR maestria != NULL) AND (doc = '' OR doc = NULL)";
            $datos["mc"] = query($query)->fetch_assoc()["mc"];
            $query = "SELECT count(*) as doc FROM docente WHERE (doc != '' OR doc != NULL)";
            $datos["doc"] = query($query)->fetch_assoc()["doc"];
            $query = "SELECT count(*) as num FROM docente";
            $datos["total"] = query($query)->fetch_assoc()["num"];
            $datos["otros"] = $datos["total"] - ($datos["lic"] + $datos["mc"] + $datos["doc"]);
            return $datos;
        }

        public function getGenerosDocentes(){
            $datos = array();
            $query = "SELECT count(*) hombres FROM docente WHERE SUBSTRING(curp FROM 11 FOR 1) = 'H';";
            $datos['hombres'] = query($query)->fetch_assoc()['hombres'];
            $query = "SELECT count(*) mujeres FROM docente WHERE SUBSTRING(curp FROM 11 FOR 1) = 'M';";
            $datos['mujeres'] = query($query)->fetch_assoc()['mujeres'];
            $query = "SELECT count(*) total FROM docente;";
            $datos['total'] = query($query)->fetch_assoc()['total'];
            return $datos;
        }

        public function registraArchivo($nombre, $seccion, $tipo){
            $query = "INSERT INTO archivos(nombre, seccion, tipo) VALUES('$nombre', $seccion, $tipo)";
            $alta = query($query);
            return $alta;
        }

        public function getArchivos($seccion){
            $query = "SELECT * FROM archivos WHERE seccion = $seccion";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($archivo = $resultado->fetch_assoc()) {
                $lista[$i] = $archivo;
                $i++;
            }
            return $lista;
        }

        public function getDocentesFiltro($filtro = ""){
            if(!$filtro)
                $filtro = "0";
            
            $qr = "SELECT e.idMap AS estado, count(d.folio) AS numero FROM estado e INNER JOIN docente d ON d.estado = e.clave WHERE $filtro GROUP BY e.clave";
            $resultado = query($qr);
            $lista = array();
            $i = 0;
            while ($archivo = $resultado->fetch_assoc()) {
                $lista[$i] = $archivo;
                $i++;
            }
            return $lista;
        }

        public function getDocentesEvaluacion($idEvaluacion, $periodo){
            $query = "SELECT d.* FROM evaluaciondocente ed INNER JOIN docente d ON ed.docente = d.folio WHERE ed.evaluacion = $idEvaluacion AND ed.periodo = '$periodo' AND ed.fechaTermino IS NOT NULL;";
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