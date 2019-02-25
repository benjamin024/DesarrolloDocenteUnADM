<?php
    include_once("database.php");

    class periodo{

        public function getPeriodos(){
            $query = "SELECT * FROM periodo";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($periodo = $resultado->fetch_assoc()) {
                $lista[$i] = $periodo;
                $i++;
            }
            return $lista;

        }
        
        public function getPeriodoActual(){
            $query = "SELECT * FROM periodo WHERE NOW() BETWEEN inicio AND termino;";
            $resultado = query($query);
            $periodo = $resultado->fetch_assoc();
            return $periodo;
        }

        public function getPeriodosFuturos($fecha){
            $query = "SELECT * FROM periodo WHERE inicio > '$fecha' ORDER BY inicio ASC";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($periodo = $resultado->fetch_assoc()) {
                $lista[$i] = $periodo;
                $i++;
            }
            return $lista;
        }

        public function getPeriodosAnteriores($fecha){
            $query = "SELECT * FROM periodo WHERE termino < '$fecha' ORDER BY inicio DESC";
            $resultado = query($query);
            $lista = array();
            $i = 0;
            while ($periodo = $resultado->fetch_assoc()) {
                $lista[$i] = $periodo;
                $i++;
            }
            return $lista;
        }
        
    }
?>