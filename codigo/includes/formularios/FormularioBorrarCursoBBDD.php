<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioBorrarCursoBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        return  '<label>Facultad</label>
                <select data-caso="BorrarCurso" name="facultad" class="selector" id="facultadBorrarCurso" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <select data-caso="BorrarCurso" name="grado" class="selector" id="gradoBorrarCurso" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <select name="curso" class="selector" id="cursoBorrarCurso" disabled required>
                    <option value="" disabled selected>Elija un curso</option>
                </select>
                <button type="submit" id="borrarCurso">Borrar curso</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $curso = (int)$_REQUEST['curso'];

        if (Universidad::existeCursoID($curso)) {
            Universidad::borrarCurso($curso);
            $mensajesFormulario[] = "Curso eliminado correctamente";
            $mensajesFormulario[] = "exito";
        }
        else {
            $mensajesFormulario[] = "Error en la base de datos";
            $mensajesFormulario[] = "fracaso";
        }
        
        return $mensajesFormulario;
    }
}