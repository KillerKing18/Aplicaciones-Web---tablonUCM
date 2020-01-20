<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Reporte.php';

class FormularioReporte extends Form {

    public function generaCamposFormulario($datosIniciales) {
        return  '<label>Asunto</label>
                <input type="text" name="asunto" maxlength="30" required></input>
                <label>Mensaje</label>
                <textarea rows="4" name="texto" maxlength="280" required></textarea>
                <button type="submit" id="reporte">Enviar</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $caso = substr($_REQUEST['action'], 13);

        Reporte::creaReporte(date("Y-m-d H:i:s"), $_REQUEST['asunto'], $_REQUEST['texto'], $_SESSION['nombre'], $_REQUEST['id'], $caso);
        
        $mensajesFormulario[] = "Reporte enviado correctamente";
        $mensajesFormulario[] = "exito";
        
        return $mensajesFormulario;
    }
}