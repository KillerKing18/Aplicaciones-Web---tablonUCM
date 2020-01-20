<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Archivo.php';
require_once __DIR__.'/../Universidad.php';

$asignatura = (int)$_POST['asignatura'];
$array = Archivo::generaBusquedaGeneral($asignatura);

echo json_encode($array);
?>