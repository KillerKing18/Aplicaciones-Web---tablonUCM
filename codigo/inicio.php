<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Novedad.php';
if(!isset($_SESSION['login']))
	header('Location: login.php');
$_SESSION['seccion'] = 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
	<link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Portada</title>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/cabecera.js"></script>
</head>

<body>

<div id="contenedor">
	<?php
		$admin = $_SESSION['esAdmin'] ? "Admin" : "";
		require("includes/comun/cabecera" . $admin . ".php");
	?>

	<div class="contenido" id="inicio">
		<h1>Bienvenido a tablónUCM</h1>
		<img alt="Logo tablónUCM" id="logo-inicio" src="img/pagina/tablonUCMLogo.png"/>
		<p id="descripcion">Bienvenido a tablónUCM. Aquí podrás estar al día en todo lo referente a tu carrera universitaria. tablónUCM te permite subir apuntes, compartirlos con otras personas y que estos los valoren si son de su utilidad o no. Al igual que tú, más usuarios subirán sus apuntes los cuales te serán de gran utilidad y harán tu día a día mucho más sencillo.</p>
		<div class="novedades">
			<?php
				echo Novedad::mostrarNovedades();
			?>
		</div>
	</div>

<?php
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>