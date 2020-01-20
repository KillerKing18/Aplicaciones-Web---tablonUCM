<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/formularios/FormularioBusqueda.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
$_SESSION['seccion'] = 'buscador';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Buscar</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/cabecera.js"></script>
    <script src="js/selectores.js"></script>
    <script src="js/buscador.js"></script>
</head>

<body>
    <div id="contenedor">
        <?php
			$admin = $_SESSION['esAdmin'] ? "Admin" : "";
	        require("includes/comun/cabecera" . $admin . ".php");
		?>
        <div class="contenido" id="buscador">
            <div class="formulario-buscador buscador" id="buscador-selectores">
                <h2>BUSCADOR</h2>
				<?php
					$formularioBusqueda = new FormularioBusqueda("form-search", array( 'action' => 'buscador.php'));
					$formularioBusqueda->gestiona();
                ?>
            </div>
            <div class="resultados buscador" id = "Teoría">
                <h2>Teoría</h2>
            </div>
            <div class="resultados buscador" id = "Ejercicios">
                <h2>Ejercicios</h2>
            </div>
            <div class="resultados buscador" id = "Prácticas">
                <h2>Prácticas</h2>
            </div>
            <div class="resultados buscador" id = "Exámenes">
                <h2>Exámenes</h2>
            </div>   
        </div>

		<?php
			require("includes/comun/pie.php");
		?>
    </div>
</body>

</html>