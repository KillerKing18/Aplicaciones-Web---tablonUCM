<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Evento.php';
require_once __DIR__.'/includes/formularios/FormularioReporte.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Evento</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/asistentes.js"></script>
    <script src="js/edicionObjetos.js"></script>
    <script src="js/mensajeValidacion.js"></script>
</head>

<body>

    <div id="contenedor">
        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="resultadoEvento">
            <div id="divMensajes">
			
            </div>
            <?php
                Evento::mostrarEvento();
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>