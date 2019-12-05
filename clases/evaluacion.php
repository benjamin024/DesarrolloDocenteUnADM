<?php
    include_once("database.php");

    class evaluacion{

		public function getIndicadorCalificacion($docente){
            $query = "SELECT t1.*, t2.periodo, t2.calificacion FROM criterioCalificacion as t1, evaluacionDocente as t2 WHERE t1.idEvaluacion = t2.idEvaluacionDocente AND t2.docente ='$docente' order by t1.criterio asc";
            $calificacionBD = query($query);

            $lista = array();
            $i = 0;
            while ($evaluacion = $calificacionBD->fetch_assoc()) {
                $lista[$i] = $evaluacion;
                $i++;
            }
            return $lista;
        }

        public function getListaEvaluaciones(){
            $query = "SELECT * FROM evaluacion where idEvaluacion = 1";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($evaluacion = $resultado->fetch_assoc()) {
                $lista[$i] = $evaluacion;
                $i++;
            }
            return $lista;
        }

        public function getCriterios($idEvaluacion){
            $query = "SELECT * FROM criterio WHERE idEvaluacion = $idEvaluacion";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($evaluacion = $resultado->fetch_assoc()) {
                $lista[$i] = $evaluacion;
                $i++;
            }
            return $lista;
        }

        public function getIndicadores($idCriterio){
            $query = "SELECT * FROM indicador WHERE idCriterio = $idCriterio";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($indicador = $resultado->fetch_assoc()) {
                $lista[$i] = $indicador;
                $i++;
            }
            return $lista;
        }

        public function getIndicador($idIndicador){
            $query = "SELECT * FROM indicador WHERE idIndicador = $idIndicador";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($indicador = $resultado->fetch_assoc()) {
                $lista[$i] = $indicador;
                $i++;
            }
            return $lista;
        }

        public function getEscalaEvaluacion(){
            $query = "SELECT * FROM escalaEvaluacion ORDER BY puntos DESC";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($escala = $resultado->fetch_assoc()) {
                $lista[$i] = $escala;
                $i++;
            }
            return $lista;
        }

        public function getIndicadorEscala($idIndicador){
            $query = "SELECT * FROM indicadorEscala WHERE idIndicador = $idIndicador ORDER BY idIndicador ASC, escala DESC";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($evaluacion = $resultado->fetch_assoc()) {
                $lista[$i] = $evaluacion;
                $i++;
            }
            return $lista;
        }

        public function updateEvaluacion($id, $nombre, $porcentaje){
            $query = "UPDATE evaluacion SET nombre='$nombre', porcentaje = '$porcentaje' WHERE idEvaluacion = $id;";
            $update = query($query);
            return $update;
        }

        public function updateCriterio($id, $nombre, $porcentaje){
            $query = "UPDATE criterio SET nombre='$nombre', porcentaje = '$porcentaje' WHERE idCriterio = $id;";
            $update = query($query);
            return $update;
        }

        public function deleteCriterio($id){
            $query = "DELETE FROM criterio WHERE idCriterio = $id";
            $delete = query($query);
            return $delete;
        }

        public function addCriterio($criterio, $porcentaje, $evaluacion){
            $query = "INSERT INTO criterio (nombre, porcentaje, idEvaluacion) VALUES ('$criterio', $porcentaje, $evaluacion);"; 
            $insert = query($query);
            return $insert;
        }

        public function addIndicador($idCriterio, $titulo, $mensaje, $diez, $ocho, $seis, $tres){
            $query = "INSERT INTO indicador (titulo, mensaje, idCriterio) VALUES('$titulo', '$mensaje', $idCriterio)";
            echo $query."<br>";
            $insert = query($query);
            $query = "SELECT LAST_INSERT_ID()";
            $resultado = query($query);
            $idIndicador = $resultado->fetch_assoc()["LAST_INSERT_ID()"];
            $query = "INSERT into indicadorEscala (idIndicador, escala, texto) VALUES($idIndicador,10, '$diez'), ($idIndicador, 8, '$ocho'), ($idIndicador, 6, '$seis'), ($idIndicador, 3, '$tres')";
            $insert = $insert & query($query);
            return $insert;
        }

        public function deleteIndicador($idIndicador){
            $query = "DELETE FROM indicador WHERE idIndicador = $idIndicador";
            $delete = query($query);
            return $delete;
        }

        public function updateIndicador($id, $titulo, $mensaje, $diez, $ocho, $seis, $tres){
            $query = "UPDATE indicador SET titulo='$titulo', mensaje = '$mensaje' WHERE idIndicador = $id;";
            $update = query($query);
            $query = "UPDATE indicadorEscala SET texto = '$diez' WHERE idIndicador = $id AND escala = 10";
            $update = $update & query($query);
            $query = "UPDATE indicadorEscala SET texto = '$ocho' WHERE idIndicador = $id AND escala = 8";
            $update = $update & query($query);
            $query = "UPDATE indicadorEscala SET texto = '$seis' WHERE idIndicador = $id AND escala = 6";
            $update = $update & query($query);
            $query = "UPDATE indicadorEscala SET texto = '$tres' WHERE idIndicador = $id AND escala = 3";
            $update = $update & query($query);
            return $update;
        }

        public function getEvaluacionesDisponibles($evaluacion, $docente){
            $query = "SELECT periodo FROM periodo WHERE periodo NOT IN(SELECT periodo FROM evaluacionDocente WHERE docente='$docente' AND evaluacion = $evaluacion AND fechaTermino IS NOT NULL) AND evaluaciones = 1";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($periodo = $resultado->fetch_assoc()) {
                $lista[$i] = $periodo["periodo"];
                $i++;
            }
            return $lista;
        }

        public function getCriteriosPorcentaje($idEvaluacion){
            $query = "SELECT * FROM evaluacionDocente WHERE idEvaluacionDocente = $idEvaluacion";
            $resultado = query($query)->fetch_assoc();
            
            $evaluacion = $resultado["evaluacion"];
            $docente = $resultado["docente"];
            $periodo = $resultado["periodo"];

            $criterios = $this->getCriterios($evaluacion);
            $data = array();
            foreach($criterios as $criterio){
                $numTotalInd = query("SELECT count(*) as num FROM indicador WHERE idCriterio = ".$criterio["idCriterio"])->fetch_assoc()["num"];
                $evaluados = query("SELECT count(*) as num FROM indicadorCalificacion WHERE idEvaluacion = $idEvaluacion AND indicador IN (SELECT idIndicador FROM indicador WHERE idCriterio = ".$criterio["idCriterio"].");")->fetch_assoc()["num"];
                $aux["idCriterio"] = $criterio["idCriterio"];
                $aux["criterio"] = $criterio["nombre"];
                $aux["porcentaje"] = ($evaluados / $numTotalInd) * 100;
                
                $data[] = $aux;
            }
            return $data;
        }

        public function registraCalificacion($idEvaluacion, $indicador, $calificacion){
            $qr = "SELECT count(*) as existe FROM indicadorCalificacion WHERE idEvaluacion = $idEvaluacion AND indicador = $indicador";
            $existe = query($qr)->fetch_assoc()["existe"];
            if($existe)
                $qr = "UPDATE indicadorCalificacion SET calificacion = $calificacion WHERE idEvaluacion = $idEvaluacion AND indicador = $indicador;";
            else
                $qr = "INSERT into indicadorCalificacion(idEvaluacion, indicador, calificacion) VALUES($idEvaluacion, $indicador, $calificacion);";
            query($qr);
            $qr = "UPDATE evaluacionDocente SET ultimaActualizacion = NOW() WHERE idEvaluacionDocente = $idEvaluacion";
            query($qr);
            $qr = "SELECT docente, evaluacion, periodo FROM evaluacionDocente WHERE idEvaluacionDocente = $idEvaluacion";
            return query($qr)->fetch_assoc();
        }

        public function limpiaEvaluacion($id){
            $query = "DELETE FROM indicadorCalificacion WHERE idEvaluacion = $id";
            $delete = query($query);
            $qr = "UPDATE evaluacionDocente SET ultimaActualizacion = NOW() WHERE idEvaluacionDocente = $id";
            query($qr);
            return $delete;
        }

        public function getCalificacionIndicador($idEvaluacion, $indicador){
            $query = "SELECT calificacion FROM indicadorCalificacion WHERE idEvaluacion = $idEvaluacion AND indicador = $indicador";
            $calificacionBD = query($query);
            if($calificacionBD->num_rows > 0)
                $calificacion = $calificacionBD->fetch_assoc()["calificacion"];
            else
                $calificacion = 0;
            return $calificacion;
        }

        public function calificaCriterio($idEvaluacion, $criterio, $calificacion){
            $query = "INSERT into criterioCalificacion VALUES($idEvaluacion, $criterio, $calificacion);";
            $insert = query($query);
            return $insert;
        }

        public function getObservaciones(){
            $query = "SELECT * FROM observaciones";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($observacion = $resultado->fetch_assoc()) {
                $lista[$i] = $observacion;
                $i++;
            }
            return $lista;

        }

        public function registraCalificacionFinal($idEvaluacion, $calificacion, $observaciones, $comentario){
            $query = "UPDATE evaluacionDocente SET ultimaActualizacion = NOW(), fechaTermino = NOW(), calificacion = $calificacion, comentario = '$comentario' WHERE idEvaluacionDocente = $idEvaluacion";
            echo $query;
            $update = query($query);
            foreach($observaciones as $o){
                $query = "INSERT into evaluacionObservacion VALUES ($idEvaluacion, $o);";
                query($query);
            }
            return $update;
        }

        public function getCalificacionesDocente($docente){
            include_once("periodo.php");
            $p = new periodo();
            $periodos = $p->getPeriodos();
            $evaluaciones = $this->getListaEvaluaciones();
            $data = array();
            
            foreach($periodos as $p){

                $auxArray = array();
                $calTotal = 0;

                $tieneEvaluacion = query("SELECT count(*) num FROM evaluacionDocente WHERE periodo = '".$p["periodo"]."' AND docente = '$docente'")->fetch_assoc()["num"];
                
                if($tieneEvaluacion){
                    $auxArray["periodo"] = $p["periodo"];
                    foreach($evaluaciones as $ev){
                        $evaluacion = query("SELECT * FROM evaluacionDocente WHERE docente = '$docente' AND evaluacion = ".$ev["idEvaluacion"]." AND periodo = '".$p["periodo"]."'")->fetch_assoc();
                        if($evaluacion){
                            if($evaluacion["calificacion"]){
                                $auxArray["evaluacion_".$ev["idEvaluacion"]] = $evaluacion["calificacion"];
                                $calTotal += $evaluacion["calificacion"] * $ev["porcentaje"] / 100;
                            }
                            else
                                $auxArray["evaluacion_".$ev["idEvaluacion"]] = "Esta evaluación aún no se termina.<br>Última actualización:<br>".$evaluacion["ultimaActualizacion"];
                            $auxArray["idEvaluacion"] = $evaluacion["idEvaluacionDocente"];
                        }else{
                            $auxArray["evaluacion_".$ev["idEvaluacion"]] = "Aún no se aplica esta evaluación";
                        }
                    }
                    $auxArray["calificacionFinal"] = $calTotal;
                }
                if($auxArray)
                    $data[] = $auxArray;
            }
            return $data;
        }

        public function getObservacionesEvaluacion($evaluacion){
            $observaciones = query("SELECT * FROM evaluacionObservacion WHERE evaluacion = $evaluacion");
            $lista = array();
            $i = 0;
            while ($observacion = $observaciones->fetch_assoc()) {
                $qr = "SELECT * FROM observaciones WHERE idObservacion = ".$observacion["observacion"];
                $res = query($qr);
                
                while($obs = $res->fetch_assoc()){
                    $lista[$i] = $obs["observacion"];
                    $i++;
                }
            }
            return $lista;
        }

        public function eliminarArchivo($id){
            $qr = "DELETE FROM archivos WHERE id = $id";
            $result = query($qr);
            return $result;
        }

        public function getIdEvaluacionDocente($evaluacion, $periodo, $docente){
            $query = "SELECT idEvaluacionDocente FROM evaluaciondocente WHERE evaluacion = $evaluacion AND periodo = '$periodo' AND docente = '$docente';";
            $resultado = query($query);
            return $resultado->fetch_assoc()["idEvaluacionDocente"];
        }
    }
?>