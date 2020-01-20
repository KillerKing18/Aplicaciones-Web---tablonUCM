<?php
	require_once __DIR__.'/includes/config.php';

	if(!isset($_SESSION['login']))
		header('Location: login.php');
		
	//Doble seguridad: unset + destroy
	unset($_SESSION["login"]);
	unset($_SESSION["esAdmin"]);
	unset($_SESSION["nombre"]);
	session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
		<link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Log out</title>
	</head>

	<body>

		<div id="contenedor">

		<?php
			require("includes/comun/cabeceraLogin.php");
		?>

			<div class="contenido" id="logout">
				<div id="logoutForm">
					<h1>¡Gracias por su visita!</h1>
					<form action="login.php">
						<button type="submit" id="button-logout">Vuelve a iniciar sesión</button>
					</form>
				</div>
			</div>

		<?php
			require("includes/comun/pie.php");
		?>


		</div>

	</body>
</html>