<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

$caso = $_POST['caso'];
$facultad = isset($_POST['facultad']) ? (int)$_POST['facultad'] : null;
$grado = isset($_POST['grado']) ? (int)$_POST['grado'] : null;
$curso = isset($_POST['curso']) ? (int)$_POST['curso'] : null;
$result = '';
switch($caso){
    case 'facultad':
        $result = Universidad::creaOpcionesGenerico($facultad, 'Facultad', 'grados', 'un grado', 'grados para esta facultad', false);
    break;
    case 'grado':
        $result = Universidad::creaOpcionesGenerico($grado, 'Grado', 'cursos', 'un curso', 'cursos para este grado', false);
    break;
    case 'curso':
        $result = Universidad::creaOpcionesGenerico($curso, 'Curso', 'asignaturas', 'una asignatura', 'asignaturas para este curso', false);
    break;
    case 'asignatura':
        $result = Universidad::creaOpcionesCategorias();
    break;
}
echo $result;

?>