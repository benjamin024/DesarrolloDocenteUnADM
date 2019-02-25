<?php
    require("../clases/evaluacion.php");
    $e = new evaluacion();

    $id =@$_POST["idCriterio"];

    echo $e->deleteCriterio($id);
?>