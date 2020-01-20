<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioAsignaturaBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        return  '<label>Facultad</label>
                <select data-caso="Asignatura" name="facultad" class="selector" id="facultadAsignatura" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <select data-caso="Asignatura" name="grado" class="selector" id="gradoAsignatura" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <select name="curso" class="selector" id="cursoAsignatura" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <label>Asignatura</label>
                <input type="text" name="asignatura" maxlength="80" required></input>
                <button type="submit" id="crearAsignatura">Añadir asignatura</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $curso = $_REQUEST['curso'];
        $asignatura = $_REQUEST['asignatura'];

        if (Universidad::existeObjetoUniversidad($asignatura, $curso, 'asignaturas', 'Curso')) {
            $mensajesFormulario[] = "Ya existe una asignatura de esas características";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            Universidad::creaAsignatura($asignatura, $curso);
            $mensajesFormulario[] = "Asignatura añadida correctamente";
            $mensajesFormulario[] = "exito";        
        }
        
        return $mensajesFormulario;
    }
}
