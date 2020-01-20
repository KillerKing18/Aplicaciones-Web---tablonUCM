<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Resultado</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/archivos.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/resultadoApuntes.js"></script>
</head>

<body>

    <div id="contenedor-resultadoApuntes">

        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="busquedaAsignatura">
            <?php
                Archivo::generarResultadoBusqueda();
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>