<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
require_once __DIR__.'/includes/Universidad.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
$_SESSION['seccion'] = 'apuntes';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Mis asignaturas y archivos</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="apuntes">
            <div class="asignaturas">
                <h1>Asignaturas marcadas</h1>
                <?php
                    echo Universidad::mostrarAsignaturasMarcadas($_SESSION['nombre']);
                ?>
            </div>
            <div class="archivos">
                <?php
                    echo Archivo::generaArchivosUsuario(false, $_SESSION['nombre']);
                ?>
            </div>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>