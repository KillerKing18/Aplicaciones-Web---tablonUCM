<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Evento.php';

class FormularioDescripcionEvento extends Form{

    public function generaCamposFormulario($datosIniciales) {
        return  '<label>Nuevo descripcion del evento:</label>
                <div id="camposDescripcionEvento">
                    <div id="textAreaIconoCambioDescripcion">
                        <textarea data-id-evento="' . (int)$_GET['id'] . '" class="validacion" name="descripcionEvento" id="eventoCambioDescripcion" maxlength="140" required></textarea><span id="iconoeventoCambioDescripcion" class="iconoValidacion"></span>
                    </div>
                    <button id="descripcionEvento" type="submit" class="edicionEvento">Actualizar</button>
                </div>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $descripcionEvento = $_REQUEST['descripcionEvento'];
        $idEvento = (int)$_GET['id'];
        if (!Evento::editarDescripcion($idEvento, $descripcionEvento)) {
            $mensajesFormulario[] = "La nueva descripción no puede ser la misma que la antigua";
            $mensajesFormulario[] = "fracaso";
        }
        else
            echo '<script>document.location.href = "resultadoEvento.php?id=' . $idEvento . '";</script>';

        return $mensajesFormulario;
    }
}