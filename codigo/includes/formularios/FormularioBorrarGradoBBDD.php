<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioBorrarGradoBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        return  '<label>Facultad</label>
                <select data-caso="BorrarGrado" name="facultad" class="selector" id="facultadBorrarGrado" required>'
                . $options .
                '</select>
                <label>Grado</label>
                <select name="grado" class="selector" id="gradoBorrarGrado" disabled required>
                    <option value="" disabled selected>Elija un grado</option>
                </select>
                <button type="submit" id="borrarGrado">Borrar grado</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $grado = (int)$_REQUEST['grado'];

        if (Universidad::existeGradoID($grado)) {
            Universidad::borrarGrado($grado);
            $mensajesFormulario[] = "Grado eliminado correctamente";
            $mensajesFormulario[] = "exito";
        }
        else {
            $mensajesFormulario[] = "Error en la base de datos";
            $mensajesFormulario[] = "fracaso";
        }

        return $mensajesFormulario;
    }
}