<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

$idAsignatura = (int)$_POST['idAsignatura'];
$idUsuario = $_SESSION['nombre'];

if (Universidad::asignaturaMarcada($idAsignatura, $idUsuario)) {
    Universidad::desmarcarAsignatura($idAsignatura, $idUsuario);
    echo 0;
}
else {
    Universidad::marcarAsignatura($idAsignatura, $idUsuario);
    echo 1;
}

?>