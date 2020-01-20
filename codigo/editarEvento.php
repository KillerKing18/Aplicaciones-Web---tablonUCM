<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Evento.php';
require_once __DIR__.'/includes/formularios/FormularioNombreEvento.php';
require_once __DIR__.'/includes/formularios/FormularioFechaEvento.php';
require_once __DIR__.'/includes/formularios/FormularioLugarEvento.php';
require_once __DIR__.'/includes/formularios/FormularioDescripcionEvento.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
$evento = Evento::devuelveObjetoEvento($_REQUEST['id']);
if (!$evento || (Evento::devuelveCreadorEvento($evento) !== $_SESSION['nombre'] && !$_SESSION['esAdmin'])) {
    http_response_code(403);
    die('403 - Forbidden');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Editar evento</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/validacion.js"></script>
    <script src="js/mensajeValidacion.js"></script>
    <script src="js/eventos.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="editarEvento">
            <?php
                Evento::editarEvento();
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>