<?php
    session_start();
    include_once("clases/usuario.php");
    $u = new usuario();
    if (isset($_COOKIE["usuario_UnADM"]) && isset($_COOKIE["clave_UnADM"]) && $_COOKIE["usuario_UnADM"] != "" && $_COOKIE["clave_UnADM"] != ""){
        if($u->logueadoCookies()){
            $_SESSION["usuario_UnaDM"] = $_COOKIE["usuario_UnADM"];
            header("location: operador/docentes.php");
        }
    }
    //REVISAR TIPO DE USUARIO!!!!
    if(isset($_SESSION["usuario_UnADM"]) && $_SESSION["usuario_UnADM"] != ""){
        header("location: operador/docentes.php");
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Iniciar sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/colores_institucionales.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        $error =@$_GET["error"];

        if($error == 1){
            $modal = "$('#modalError').modal('toggle')";
            echo "<script>$(document).ready(function(){{$modal}});</script>";
        }
    ?>
    <div class="container-fluid" style="padding: 0px !important;">
        <div class="row" style="background-color: #FFF; position: absolute; width: 100%; height: 100px; margin: 0px; ">
            <img src="img/sep.png" style="max-height: 60px; position: absolute; top: 20px; left: 100px;">
            <img src="img/unadm.png" style="max-height: 60px; position: absolute; top: 20px; right: 100px;">
        </div>
        <div class="row align-items-center h-100"  style="position: absolute; top: 0px; padding-top: 100px; width: 100%; z-index: -1; height:100%; margin: 0px;  justify-content: center; background-image: url('img/fondo_index.jpg'); background-repeat: no-repeat;background-size: cover;background-position-y: 100px;">
            <div class="card" style="min-width: 35%; height: 350px; background-color: rgba(255, 255, 255, 0.4);">
                <div class="card-body justify-content-center">
                    <h4 class="card-title" style="text-align: center;">Iniciar sesión</h4>
                        <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="usuario">Nombre de usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa el nombre de usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingresa tu contraseña" required>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="recuerda" name="recuerda">
                            <label class="form-check-label" for="recuerda">Mantener sesión iniciada</label>
                        </div><br>
                        <center><button class="btn btn-success">Aceptar</button></center>
                        </form>
                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="modalError">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Usuario y/o contraseña incorrectos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    El usuario o la contraseña que se ingresó son incorrectos, revisa la información y vuelve a intentarlo.<br><br>
                    <small>Si crees que se trata de un error, comunícate con el administrador del sistema.</small><br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">   
                    <button class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>