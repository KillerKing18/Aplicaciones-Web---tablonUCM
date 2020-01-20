<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/formularios/FormularioLogin.php';
if (isset($_SESSION['emailUsuario']))
    unset($_SESSION['emailUsuario']);
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
    <title>Log In</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/mensajeValidacion.js"></script>
</head>

<body>
    <div id="contenedor">
        <?php
            require("includes/comun/cabeceraLogin.php");
        ?>

        <div class="contenido" id="login">

            <div id="LoginForm">
                <h1>Iniciar sesión</h1>
                <div id="divMensajes" class="login">
			
                </div>
                <?php
                    $formularioLogin = new FormularioLogin("form-login", array( 'action' => 'login.php'));
                    $formularioLogin->gestiona();
                ?>
            </div>

        </div>

        <?php
            require("includes/comun/pie.php");
        ?>
    </div>
</body>

</html>