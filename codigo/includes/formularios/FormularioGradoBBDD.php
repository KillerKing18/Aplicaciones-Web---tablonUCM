<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioGradoBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        return  '<label>Facultad</label>
                <select name="facultad" class="selector" id="facultadGrado" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <input type="text" name="grado" maxlength="80" required></input>
                <button type="submit" id="crearGrado">Añadir grado</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $facultad = $_REQUEST['facultad'];
        $grado = $_REQUEST['grado'];

        if (Universidad::existeObjetoUniversidad($grado, $facultad, 'grados', 'Facultad')) {
            $mensajesFormulario[] = "Ya existe un grado de esas características";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            Universidad::creaObjetoUniversidad($grado, $facultad, 'grados', 'Facultad');
            $mensajesFormulario[] = "Grado añadido correctamente";
            $mensajesFormulario[] = "exito";        
        }
        
        return $mensajesFormulario;
    }
}