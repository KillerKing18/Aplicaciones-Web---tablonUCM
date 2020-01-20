<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
require_once __DIR__.'/includes/Reporte.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarReporte.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
else if (!$_SESSION['esAdmin'])
    header('Location: inicio.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Reporte</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/mensajeValidacion.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="reporte">
            <div id="divMensajes">
			
            </div>
            <?php
                Reporte::mostrarReporte($_REQUEST['caso']);
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>