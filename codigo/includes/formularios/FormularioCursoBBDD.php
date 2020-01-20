<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioCursoBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        return  '<label>Facultad</label>
                <select data-caso="Curso" name="facultad" class="selector" id="facultadCurso" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <select name="grado" class="selector" id="gradoCurso" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <label>Curso</label>
                <input type="text" name="curso" maxlength="80" required></input>
                <button type="submit" id="crearCurso">Añadir curso</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $grado = $_REQUEST['grado'];
        $curso = $_REQUEST['curso'];

        if (Universidad::existeObjetoUniversidad($curso, $grado, 'cursos', 'Grado')) {
            $mensajesFormulario[] = "Ya existe un curso de esas características";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            Universidad::creaObjetoUniversidad($curso, $grado, 'cursos', 'Grado');
            $mensajesFormulario[] = "Curso añadido correctamente";
            $mensajesFormulario[] = "exito";        
        }
        
        return $mensajesFormulario;
    }
}