<?php
    require("../clases/evaluacion.php");
    $e = new evaluacion();

    $id =@$_POST["idIndicador"];

    echo $e->deleteIndicador($id);
?>