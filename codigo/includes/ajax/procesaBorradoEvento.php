<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Evento.php';

$id = (int)$_POST['id'];
Evento::borrarEvento($id);
echo $_SESSION['seccion'] . '.php';

?>