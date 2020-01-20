<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/formularios/FormularioRegistro.php';
if (isset($_SESSION['login']))
    unset($_SESSION['login']);
if (isset($_SESSION['esAdmin']))
    unset($_SESSION['esAdmin']);
if (isset($_SESSION['nombre']))
    unset($_SESSION['nombre']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="css/estilo.css"/>
    <link rel="icon" href="img/pagina/tablonUCMLogo.png"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Registro</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/validacion.js"></script>
    <script src="js/mensajeValidacion.js"></script>
</head>

<body>
    <div id="contenedor">
        <?php
            require("includes/comun/cabeceraLogin.php");
        ?>

        <div class="contenido" id="registro">

            <div id="RegisterForm">
                <h1>Registrar usuario</h1>
                <div id="divMensajes" class="registro">
			
                </div>
                <?php
                    $formularioRegistro = new FormularioRegistro("form-registro", array( 'action' => 'registro.php'));
                    $formularioRegistro->gestiona();
                ?>
            </div>

        </div>

        <?php
            require("includes/comun/pie.php");
        ?>
    </div>
</body>

</html>