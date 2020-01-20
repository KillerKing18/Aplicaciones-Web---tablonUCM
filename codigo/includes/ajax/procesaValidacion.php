<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';
require_once __DIR__.'/../Archivo.php';
require_once __DIR__.'/../Evento.php';

$text = $_POST['text'];
$caso = $_POST['caso'];
$idArchivo = (int)$_POST['idArchivo'];
$idEvento = (int)$_POST['idEvento'];

switch($caso){
    case 'usuarioCambio':
        if(isset($_SESSION['nombre']) && $_SESSION['nombre'] === $text)
            echo -1;
        else if(!Usuario::buscaUsuario($text))
            echo 0;
        else
            echo 1;    
        break;
    case 'usuarioRegistro':
        if(!Usuario::buscaUsuario($text))
            echo 0;
        else
            echo 1;    
        break;
    case 'emailPerfil':
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        if($usuario->email() === $text)
            echo 1;
        else
            echo 0; 
        break;
    case 'archivoCambioNombre':
        $archivo = Archivo::devuelveObjetoArchivo($idArchivo);
        if($archivo->nombre() === $text)
            echo 1;
        else
            echo 0; 
        break;
        case 'archivoCambioObservaciones':
        $archivo = Archivo::devuelveObjetoArchivo($idArchivo);
        if($archivo->observaciones() === $text)
            echo 1;
        else
            echo 0; 
        break;
    case 'eventoCambioNombre':
        $evento = Evento::devuelveObjetoEvento($idEvento);
        if($evento->nombre() === $text)
            echo 1;
        else
            echo 0; 
        break;
    case 'eventoCambioLugar':
        $evento = Evento::devuelveObjetoEvento($idEvento);
        if($evento->lugar() === $text)
            echo 1;
        else
            echo 0; 
        break;
    case 'eventoCambioDescripcion':
        $evento = Evento::devuelveObjetoEvento($idEvento);
        if($evento->descripcion() === $text)
            echo 1;
        else
            echo 0; 
        break;
}
?>