<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Información del docente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap-toggle.css">
    <link rel="stylesheet" href="../css/colores_institucionales.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function selecciona(archivo){
            document.getElementById("fileName").value = archivo.files[0].name;
        }

        function envia(){
            var area = document.getElementById("seccion").value;
            var archivo = document.getElementById("fileName").value;
            if(area == 0)
                alert("Selecciona un área");
            else if(archivo == "")
                alert("Selecciona un archivo");
            else
                document.getElementById("formulario").submit();
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <form id="formulario" action="agregaArchivo.php" target="_top" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <br><br>
                    <label for="seccion">Sección:</label>
                    <select class="form-control" id="seccion" name="seccion">
                    <option selected disabled value="0">Selecciona una sección</option>
                    <option value="1">Docentes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="seccion">Archivo:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="fileName" readonly style="background: #FFF;" placeholder="Agrega un archivo"  aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="button-addon2" onclick="document.getElementById('inputFile').click();">Seleccionar</button>
                        </div>
                    </div>
                </div>
                <br>
                <input type="file" hidden name="inputFile" id="inputFile" onchange="selecciona(this);">
                <center><button type="button" onclick="envia();" class="btn btn-success">Subir archivo</button></center>
            </form>
        </div>
    </div>
    
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-toggle.js"></script>
</body>
</html>