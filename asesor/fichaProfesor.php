<?php
    $folio = (@_GET["folio"]) ? @_GET["folio"] : $_SESSION["usuario_UnADM"];
    include("../operador/fichaProfesor.php");
?>