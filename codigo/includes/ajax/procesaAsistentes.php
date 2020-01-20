<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Evento.php';

$id = $_POST['id'];

if(!Evento::insertaAsistenteEvento($id))
    Evento::quitaAsistenteEvento($id);

$array = array();
$array[0] = Evento::devuelveAsistentesEvento($id);
$array[1] = Evento::apuntadoAEvento($id, $_SESSION['nombre']) ? "No asistiré" : "Asistiré";
echo json_encode($array);

?>