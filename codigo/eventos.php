<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Evento.php';
require_once __DIR__.'/includes/formularios/FormularioEvento.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
$_SESSION['seccion'] = 'eventos';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Eventos</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/eventos.js"></script>
    <script src="js/mensajeValidacion.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>

</head>

<body>

    <div id="contenedor">

        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="eventos">
            <div id="divMensajes">
			
            </div>
            <?php
                echo Evento::mostrarResultadoEventos();
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>