<?php
    include_once("database.php");

    class ajuste{

        public function registrarBloque($titulo, $imagen, $color, $fuente, $link, $perfil){
            $query = "INSERT INTO bloque(titulo, imagen, color, fuente, link, perfil) VALUES('$titulo', '$imagen', '$color', $fuente, '$link', $perfil)";
            echo $query;
            $alta = query($query);
            return $alta;
        }

        public function getBloques($perfil){
            $qr = "SELECT * FROM bloque WHERE perfil = $perfil;";
            $resultado = query($qr);
            $lista = array();
            $i = 0;
            while ($bloques = $resultado->fetch_assoc()) {
                $lista[$i] = $bloques;
                $i++;
            }
            return $lista;
        }

        public function getBloque($id){
            $qr = "SELECT * FROM bloque WHERE id = $id;";
            $resultado = query($qr);
            $bloque = $resultado->fetch_assoc();
            return $bloque;
        }

        public function editarBloque($id, $titulo, $imagen, $color, $fuente, $link){
            $query = "UPDATE bloque SET titulo = '$titulo', imagen = '$imagen', color = '$color', fuente = $fuente, link = '$link' WHERE id = $id";
            $update = query($query);
            return $update;
        }

        public function deleteBloque($id){
            $qr = "DELETE FROM bloque WHERE id = $id";
            $delete = query($qr);
            return $delete;
        }
    }
?>