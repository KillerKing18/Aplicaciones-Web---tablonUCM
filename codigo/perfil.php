<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Usuario.php';
require_once __DIR__.'/includes/formularios/FormularioNombreUsuario.php';
require_once __DIR__.'/includes/formularios/FormularioEmail.php';
require_once __DIR__.'/includes/formularios/FormularioPassword.php';
require_once __DIR__.'/includes/formularios/FormularioImagen.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarCuenta.php';
if(!isset($_SESSION['login']))
	header('Location: login.php');
$_SESSION['seccion'] = 'perfil';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
	<link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Perfil</title>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/perfil.js"></script>
	<script src="js/validacion.js"></script>
    <script src="js/mensajeValidacion.js"></script>
	<script src="js/cabecera.js"></script>
</head>

<body>

<div id="contenedor">

	<?php
		$admin = $_SESSION['esAdmin'] ? "Admin" : "";
		require("includes/comun/cabecera" . $admin . ".php");
	?>

	<div class="contenido" id="perfil">
		<h1>Perfil</h1>
			<div id="divMensajes">
			
            </div>
            <div class="info" id="final">
			
            </div>
			<div id="inputs-perfil">
				<div id="usuario-email">
					<div class="form-nombreUsuario">
						<h2>Cambiar nombre de usuario</h2>
						<?php
							$formularioNombreUsuario = new FormularioNombreUsuario("form-nombreUsuario", array( 'action' => 'perfil.php'));
							$formularioNombreUsuario->gestiona();
						?>
					</div>
					<div class="form-email">
						<h2>Cambiar email</h2>
						<?php
							$formularioEmail = new FormularioEmail("form-email", array( 'action' => 'perfil.php'));
							$formularioEmail->gestiona();
						?>
					</div>
				</div>
				<div class="form-password">
					<h2>Cambiar contraseña</h2>
					<?php
						$formularioPassword = new FormularioPassword("form-password", array( 'action' => 'perfil.php'));
						$formularioPassword->gestiona();
					?>
				</div>
			</div>
			<div class="form-borrarCuenta">
				<h2>Borrar cuenta</h2>
				<p>Atención: Todos los archivos asociados a tu cuenta serán borrados automáticamente.</p>
				<?php
					$formularioBorrarCuenta = new FormularioBorrarCuenta("form-borrarCuenta", array( 'action' => 'perfil.php'));
					$formularioBorrarCuenta->gestiona();
				?>
			</div>
			<div class="form-imagen">
				<?php
					$formularioImagen = new FormularioImagen("form-imagen", array( 'action' => 'perfil.php'));
					$formularioImagen->gestiona();
				?>
			</div>
			<div class="info" id="provisional">
				<?php
                    $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
                    echo $usuario->mostrarPerfil();
				?>
            </div>
	</div>

<?php
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>