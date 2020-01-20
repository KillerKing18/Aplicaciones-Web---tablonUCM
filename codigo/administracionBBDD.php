<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
require_once __DIR__.'/includes/Reporte.php';
require_once __DIR__.'/includes/formularios/FormularioAsignaturaBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioCursoBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioGradoBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioFacultadBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarFacultadBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarGradoBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarCursoBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarAsignaturaBBDD.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarBBDD.php';

if(!isset($_SESSION['login']))
    header('Location: login.php');
else if (!$_SESSION['esAdmin']){
    http_response_code(403);
    die('403 - Forbidden');
}

$_SESSION['seccion'] = 'administracionBBDD';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Administración de la base de datos</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/mensajeValidacion.js"></script>
    <script src="js/selectoresAdmin.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
            require("includes/comun/cabeceraAdmin.php");
        ?>

        <div class="contenido" id="administracionBBDD">
            <h1>Administración de la base de datos</h1>
            <div id="divMensajes">
			
            </div>
            <div class="formulario-facultad">
                <h2>Añadir facultad</h2>
				<?php
					$formularioFacultadBBDD = new FormularioFacultadBBDD("form-facultadBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioFacultadBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-facultad">
                <h2>Borrar facultad</h2>
                <p>Atención: Todos los grados, cursos, asignaturas y archivos asociados a la facultad serán borrados automáticamente</p>
				<?php
					$formularioBorrarFacultadBBDD = new FormularioBorrarFacultadBBDD("form-borrarFacultadBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioBorrarFacultadBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-grado">
                <h2>Añadir grado</h2>
				<?php
					$formularioGradoBBDD = new FormularioGradoBBDD("form-gradoBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioGradoBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-grado">
                <h2>Borrar grado</h2>
                <p>Atención: Todos los cursos, asignaturas y archivos asociados al grado serán borrados automáticamente</p>
				<?php
					$formularioBorrarGradoBBDD = new FormularioBorrarGradoBBDD("form-borrarGradoBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioBorrarGradoBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-curso">
                <h2>Añadir curso</h2>
				<?php
					$formularioCursoBBDD = new FormularioCursoBBDD("form-cursoBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioCursoBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-curso">
                <h2>Borrar curso</h2>
                <p>Atención: Todos los archivos y asignaturas asociados al curso serán borrados automáticamente</p>
				<?php
					$formularioBorrarCursoBBDD = new FormularioBorrarCursoBBDD("form-borrarCursoBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioBorrarCursoBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-asignatura">
                <h2>Añadir asignatura</h2>
				<?php
					$formularioAsignaturaBBDD = new FormularioAsignaturaBBDD("form-asignaturaBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioAsignaturaBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-asignatura">
                <h2>Borrar asignatura</h2>
                <p>Atención: Todos los archivos asociados a la asignatura serán borrados automáticamente</p>
				<?php
					$formularioBorrarAsignaturaBBDD = new FormularioBorrarAsignaturaBBDD("form-borrarAsignaturaBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioBorrarAsignaturaBBDD->gestiona();
                ?>
            </div>
            <div class="formulario-BBDD">
                <h2>Borrar base de datos</h2>
                <p>Atención: Usar solo en caso de emergencia</p>
				<?php
					$formularioBorrarBBDD = new FormularioBorrarBBDD("form-borrarBBDD", array( 'action' => 'administracionBBDD.php'));
					$formularioBorrarBBDD->gestiona();
                ?>
            </div>

        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>

</body>

</html>