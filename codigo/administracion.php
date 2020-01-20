<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
require_once __DIR__.'/includes/Reporte.php';

if(!isset($_SESSION['login']))
    header('Location: login.php');
else if (!$_SESSION['esAdmin']){
    http_response_code(403);
    die('403 - Forbidden');
}

$_SESSION['seccion'] = 'administracion';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Administración</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
</head>

<body>
    <div id="contenedor">

        <?php
            require("includes/comun/cabeceraAdmin.php");
        ?>

        <div class="contenido" id="administracion">
            <h1>Administración</h1>
            <div class="ultimosArchivos">
                <?php
                    echo Archivo::generaTodosArchivos(true);
                ?>
            </div>
            <div class="ultimosReportesEventos">
                <?php
                    echo Reporte::mostrarUltimosReportes(true, 'eventos');
                ?>
            </div>
            <div class="ultimosReportesArchivos">
                <?php
                    echo Reporte::mostrarUltimosReportes(true, 'archivos');
                ?>
            </div>
            <div class="ultimosReportesUsuarios">
                <?php
                    echo Reporte::mostrarUltimosReportes(true, 'usuarios');
                ?>
            </div>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
    
</body>

</html>