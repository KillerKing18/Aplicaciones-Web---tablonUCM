<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/formularios/FormularioUpload.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
$_SESSION['seccion'] = 'upload';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload</title>
	<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/selectores.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/upload.js"></script>
    <script src="js/mensajeValidacion.js"></script>
</head>

<body>
    <div id="contenedor">
        <?php
			$admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
		?>
        <div class="contenido" id="upload">
            <div class="upload">
                <h1>Sube tus apuntes</h1>
                <div id="divMensajes">
			
                </div>
            </div>
            <div class="formulario-upload upload">
				<?php
					$formularioUpload = new FormularioUpload("form-upload", array( 'action' => 'upload.php'));
					$formularioUpload->gestiona();
				?>
            </div>
        </div>

		<?php
			require("includes/comun/pie.php");
		?>

    </div>
</body>

</html>