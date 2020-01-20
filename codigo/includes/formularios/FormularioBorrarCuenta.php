<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';

class FormularioBorrarCuenta extends Form{

    public function generaCamposFormulario($datosIniciales) {
        return  '<button type="submit" id="borrar">Borrar cuenta</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();
        $nombre = isset($_REQUEST['id']) && $_SESSION['esAdmin'] ? $_REQUEST['id'] : $_SESSION['nombre'];
        $usuario = Usuario::buscaUsuario($nombre);
        $usuario->borrarUsuario();
        if ($_SESSION['nombre'] === $nombre) {
            unset($_SESSION['login']);
            unset($_SESSION['esAdmin']);
            unset($_SESSION['nombre']);
            session_destroy();
            echo "<script>document.location.href = 'login.php';</script>";
        }
        else
            echo "<script>document.location.href = '" . $_SESSION['seccion'] . ".php';</script>";

        return $mensajesFormulario;
    }
}