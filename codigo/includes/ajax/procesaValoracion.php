<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Valoracion.php';
require_once __DIR__.'/../Novedad.php';

$puntuacion = $_POST['puntuacion'];
$caso = $_POST['caso'];
$id = $_POST['id'];
$principio = (int)$_POST['principio'];

switch($caso){
    case 'rateArchivo':
        if ($principio)
            echo Valoracion::devuelveValoracionUsuarioArchivo($id, $_SESSION['nombre']);
        else {
            if(!Valoracion::insertaValoracionArchivo($puntuacion, $id))
                Valoracion::cambiaPuntuacionArchivo($puntuacion, $id);
            Novedad::crearNovedad('novedadesvaloracionesarchivos', 'idArchivo', $id);
            echo Valoracion::devuelveMediaValoracionesArchivo($id);
        }
        break;
    case 'rateUsuario':  
        if ($principio)
            echo Valoracion::devuelveValoracionUsuarioUsuario($id, $_SESSION['nombre']);
        else {
            if(!Valoracion::insertaValoracionUsuario($puntuacion, $id))
                Valoracion::cambiaPuntuacionUsuario($puntuacion, $id);
            Novedad::crearNovedad('novedadesvaloracionesusuarios', 'usuarioReceptor', $id);
            echo Valoracion::devuelveMediaValoracionesUsuario($id);
        }
        break;
}
?>