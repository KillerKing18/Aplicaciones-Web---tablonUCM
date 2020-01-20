<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';
require_once __DIR__.'/../Usuario.php';
require_once __DIR__.'/../Evento.php';
require_once __DIR__.'/../Valoracion.php';

class FormularioBorrarBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        return  '<button type="submit" id="borrarBBDD">Borrar base de datos</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        Usuario::borrarUsuarios();
        Universidad::borrarUniversidad();
        Evento::borrarEventos($_SESSION['nombre']);
        Valoracion::borrarValoracionesUsuario($_SESSION['nombre']);
        $mensajesFormulario[] = "Base de datos eliminada correctamente";
        $mensajesFormulario[] = "exito";
        
        return $mensajesFormulario;
    }
}