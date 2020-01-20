<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
require_once __DIR__.'/includes/formularios/FormularioReporte.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
	<link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui-stars.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Archivo</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/edicionObjetos.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/resultadoApuntes.js"></script>
    <script src="js/valoracion.js"></script>
    <script src="js/mensajeValidacion.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
</head>

<body>

    <div id="contenedor-resultadoApuntes">
        <div id="divMensajes">
			
        </div>
        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="resultadoArchivo">
            <?php
                Archivo::generarResultadoArchivo();
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>