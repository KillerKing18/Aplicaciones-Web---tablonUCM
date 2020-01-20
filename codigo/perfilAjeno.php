<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Usuario.php';
require_once __DIR__.'/includes/formularios/FormularioBorrarCuenta.php';
require_once __DIR__.'/includes/formularios/FormularioReporte.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
	<link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui-stars.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>
        <?php
            if(isset($_REQUEST['id']) && $usuario = Usuario::buscaUsuario($_REQUEST['id'])) {
                echo 'Perfil de ';
                echo $_REQUEST['id'];
            }
            else
                echo 'Perfil no encontrado';
        ?>

    </title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/perfilAjeno.js"></script>
    <script src="js/valoracion.js"></script>
    <script src="js/mensajeValidacion.js"></script>
    <script src="jquery-ui/jquery-ui.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        $admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
        ?>

        <div class="contenido" id="perfilAjeno">
            <div id="divMensajes">
			
            </div>
            <?php
                Usuario::mostrarPerfilAjeno();                    
            ?>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>