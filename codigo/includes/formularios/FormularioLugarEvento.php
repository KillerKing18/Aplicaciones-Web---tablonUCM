<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Evento.php';

class FormularioLugarEvento extends Form{

    public function generaCamposFormulario($datosIniciales) {
        return  '<label>Nuevo lugar del evento:</label>
                <div id="camposLugarEvento">
                    <div id="inputIconoCambioLugar">
                        <input data-id-evento="' . (int)$_GET['id'] . '" class="validacion" type="text" name="lugarEvento" id="eventoCambioLugar" maxlength="30" required><span id="iconoeventoCambioLugar" class="iconoValidacion"></span>
                    </div>
                    <button id="lugarEvento" type="submit" class="edicionEvento">Actualizar</button>
                </div>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $lugarEvento = $_REQUEST['lugarEvento'];
        $idEvento = (int)$_GET['id'];
        if (!Evento::editarLugar($idEvento, $lugarEvento)) {
            $mensajesFormulario[] = "El nuevo lugar no puede ser el mismo que el antiguo";
            $mensajesFormulario[] = "fracaso";
        }
        else
            echo '<script>document.location.href = "resultadoEvento.php?id=' . $idEvento . '";</script>';

        return $mensajesFormulario;
    }
}