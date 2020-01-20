<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';
require_once __DIR__.'/../Archivo.php';

class FormularioBusqueda extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);

        return  '<label>Facultad</label>
                <select name="facultad" class="selector" id="facultad" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <select name="grado" class="selector" id="grado" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <select name="curso" class="selector" id="curso" disabled required>
                    <option value="" disabled selected>Elija un curso</option>
                </select>
                <label>Asignatura</label>
                <select name="asignatura" class="selector" id="asignatura" disabled required>
                    <option value="" disabled selected>Elija una asignatura</option>
                </select>
                <div id="boton"><button type="submit" id="buscar">Buscar</button></div>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $asignatura = (int)$_REQUEST['asignatura'];
        echo '<script>document.location.href = "resultadoBuscador.php?asignatura=' . $asignatura . '";</script>';
        
        return $mensajesFormulario;
    }
}