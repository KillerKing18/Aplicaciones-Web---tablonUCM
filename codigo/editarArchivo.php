<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
require_once __DIR__.'/includes/formularios/FormularioNombreArchivo.php';
require_once __DIR__.'/includes/formularios/FormularioObservacionesArchivo.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $archivo = Archivo::devuelveObjetoArchivo($_REQUEST['id']);
    if (!$archivo || (Archivo::devuelveAutorArchivo($archivo) !== $_SESSION['nombre'] && !$_SESSION['esAdmin'])) {
        http_response_code(403);
        die('403 - Forbidden');
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Editar archivo</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/validacion.js"></script>
    <script src="js/mensajeValidacion.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="editarArchivo">
            <?php
                Archivo::editarArchivo();
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>