<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioBorrarFacultadBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        return  '<label>Facultad</label>
                <select name="facultad" class="selector" id="facultadBorrarFacultad" required>'
                . $options .
                '</select>
                <button type="submit" id="borrarFacultad">Borrar facultad</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $facultad = (int)$_REQUEST['facultad'];

        if (Universidad::existeFacultadID($facultad)) {
            Universidad::borrarFacultad($facultad);
            $mensajesFormulario[] = "Facultad eliminada correctamente";
            $mensajesFormulario[] = "exito";
        }
        else {
            $mensajesFormulario[] = "Error en la base de datos";
            $mensajesFormulario[] = "fracaso";
        }
        
        return $mensajesFormulario;
    }
}