<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Evento.php';

class FormularioNombreEvento extends Form{

    public function generaCamposFormulario($datosIniciales) {
        return  '<label>Nuevo nombre del evento:</label>
                <div id="camposNombreEvento">
                    <div id="inputIconoCambioNombre">
                        <input data-id-evento="' . (int)$_GET['id'] . '" class="validacion" type="text" name="nombreEvento" id="eventoCambioNombre" maxlength="30" required><span id="iconoeventoCambioNombre" class="iconoValidacion"></span>
                    </div>
                    <button id="nombreEvento" type="submit" class="edicionEvento">Actualizar</button>
                </div>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $nombreEvento = $_REQUEST['nombreEvento'];
        $idEvento = (int)$_GET['id'];
        if (!Evento::editarNombre($idEvento, $nombreEvento)) {
            $mensajesFormulario[] = "El nuevo nombre no puede ser el mismo que el antiguo";
            $mensajesFormulario[] = "fracaso";
        }
        else
            echo '<script>document.location.href = "resultadoEvento.php?id=' . $idEvento . '";</script>';

        return $mensajesFormulario;
    }
}