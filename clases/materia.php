<?php
    include_once("database.php");

    class materia{
        public function getListaAreas(){
            $query = "SELECT * FROM area WHERE idArea > 0";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($area = $resultado->fetch_assoc()) {
                $lista[$i] = $area;
                $i++;
            }
            return $lista;
        }

        public function getCarreras($idArea){
            $query = "SELECT * FROM carrera WHERE idArea = $idArea";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($carrera = $resultado->fetch_assoc()) {
                $lista[$i] = $carrera;
                $i++;
            }
            return $lista;
        }

        public function getNumeroModulos($idCarrera){
            $query = "SELECT MAX(modulo) as num FROM carreraMateria where idCarrera = $idCarrera";
            $numM = query($query)->fetch_assoc()["num"];
            return $numM;
        }

        public function getSemestresPorModulo($idCarrera, $modulo){
            $query = "SELECT COUNT(DISTINCT semestre) as num FROM carreraMateria where idCarrera = $idCarrera and modulo = $modulo";
            $numS = query($query)->fetch_assoc()["num"];
            return $numS;
        }

        public function getMateriasSemestre($carrera, $modulo, $semestre){
            $query = "SELECT m.* FROM materia m INNER JOIN carreraMateria cm ON m.idMateria = cm.idMateria WHERE cm.idCarrera = $carrera AND cm.modulo = $modulo AND cm.semestre = $semestre";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($materia = $resultado->fetch_assoc()) {
                $lista[$i] = $materia;
                $i++;
            }
            return $lista;
        }
    }
?>