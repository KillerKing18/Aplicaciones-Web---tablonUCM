<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';

class FormularioFacultadBBDD extends Form {

    public function generaCamposFormulario($datosIniciales) {
        return  '<label>Facultad</label>
                <input type="text" name="facultad" maxlength="80" required></input>
                <button type="submit" id="crearFacultad">Añadir facultad</button>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $facultad = $_REQUEST['facultad'];

        if (Universidad::existeFacultad($facultad)) {
            $mensajesFormulario[] = "Ya existe una facultad con ese nombre";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            Universidad::creaFacultad($facultad);
            $mensajesFormulario[] = "Facultad añadida correctamente";
            $mensajesFormulario[] = "exito";        
        }
        
        return $mensajesFormulario;
    }
}