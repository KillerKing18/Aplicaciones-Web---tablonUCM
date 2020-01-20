<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Reporte.php';

class FormularioBorrarReporte extends Form{

    public function generaCamposFormulario($datosIniciales) {
        return  '<button type="submit" id="borrar">Borrar reporte</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        if(Reporte::borrarReporte((int)$_REQUEST['id'], $_REQUEST['caso']))
            echo "<script>document.location.href = '" . $_SESSION['seccion'] . ".php';</script>";
        else {
            $mensajesFormulario[] = "No se ha podido borrar el reporte";
            $mensajesFormulario[] = "fracaso";
        }
        return $mensajesFormulario;
    }
}