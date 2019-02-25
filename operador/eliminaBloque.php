<?php
    require("../clases/ajuste.php");
    $a = new ajuste();

    $id =@$_POST["idBloque"];

    echo $a->deleteBloque($id);
?>