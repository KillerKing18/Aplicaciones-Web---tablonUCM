<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Archivo.php';

$id = (int)$_POST['id'];
Archivo::borrarArchivo($id);
echo $_SESSION['seccion'] . '.php';

?>