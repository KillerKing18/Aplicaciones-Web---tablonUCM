<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioBorrarAsignaturaBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        return  '<label>Facultad</label>
                <select data-caso="BorrarAsignatura" name="facultad" class="selector" id="facultadBorrarAsignatura" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <select data-caso="BorrarAsignatura" name="grado" class="selector" id="gradoBorrarAsignatura" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <select data-caso="BorrarAsignatura" name="curso" class="selector" id="cursoBorrarAsignatura" disabled required>
                    <option value="" disabled selected>Elija un curso</option>
                </select>
                <label>Asignatura</label>
                <select name="asignatura" class="selector" id="asignaturaBorrarAsignatura" disabled required>
                    <option value="" disabled selected>Elija una asignatura</option>
                </select>
                <button type="submit" id="borrarAsignatura">Borrar asignatura</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $asignatura = (int)$_REQUEST['asignatura'];

        if (Universidad::existeAsignaturaID($asignatura)) {
            Universidad::borrarAsignatura($asignatura);
            $mensajesFormulario[] = "Asignatura eliminada correctamente";
            $mensajesFormulario[] = "exito";
        }
        else {
            $mensajesFormulario[] = "Error en la base de datos";
            $mensajesFormulario[] = "fracaso";
        }
        
        return $mensajesFormulario;
    }
}