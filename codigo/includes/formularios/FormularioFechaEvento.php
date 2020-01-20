<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Evento.php';

class FormularioFechaEvento extends Form {

    public function generaCamposFormulario($datosIniciales) {
        $optionsHora = Evento::creaOpcionesHora();
        return  '<div id="camposFechaEvento">
                    <label>Nueva fecha del evento:</label>
                    <input autocomplete="off" type="text" name="fechaEvento" id="datepicker" required>
                </div>
                <label>Nueva hora del evento:</label>
                <div id="camposHoraEvento">
                    <select id="hora" name="horaEvento" class="selector" required>'
                        . $optionsHora .
                    '</select>
                    <button id="fechaEvento" type="submit" class="edicionEvento">Actualizar</button>
                </div>';
    }

    public function procesaFormulario($datos) {
        $mensajesFormulario = array();

        $fechaEvento = substr($_REQUEST['fechaEvento'], 6, 4) . '-' . substr($_REQUEST['fechaEvento'], 0, 2) . '-' . substr($_REQUEST['fechaEvento'], 3, 2);
        $horaEvento = $_REQUEST['horaEvento'] . ':00';
        $fecha = $fechaEvento . ' ' . $horaEvento;
        $fechaActual = date("Y-m-d H:i:s");

        if((int)substr($fecha, 0, 4) < (int)substr($fechaActual, 0, 4) || ((int)substr($fechaActual, 0, 4) === (int)substr($fechaActual, 0, 4) && (int)substr($fecha, 5, 2) < (int)substr($fechaActual, 5, 2)) || ((int)substr($fecha, 0, 4) === (int)substr($fechaActual, 0, 4) && (int)substr($fecha, 5, 2) === (int)substr($fechaActual, 5, 2) && (int)substr($fecha, 8, 2) < (int)substr($fechaActual, 8, 2))) {
            $mensajesFormulario[] = "No puedes cambiar la fecha del evento a una anterior a la actual";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            $idEvento = (int)$_GET['id'];
            Evento::editarFecha($idEvento, $fecha);
            echo '<script>document.location.href = "resultadoEvento.php?id=' . $idEvento . '";</script>';
        }

        return $mensajesFormulario;
    }
}