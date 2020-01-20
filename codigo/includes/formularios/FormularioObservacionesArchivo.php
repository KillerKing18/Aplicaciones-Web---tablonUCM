<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Archivo.php';

class FormularioObservacionesArchivo extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<label>Observaciones del archivo:</label>
                <div id="camposObservacionesArchivo">
                    <div id="textAreaIconoCambioObservaciones">
                        <textarea data-id-archivo="' . (int)$_GET['id'] . '" class="validacion" name="observacionesArchivo" id="archivoCambioObservaciones" maxlength="140" required></textarea><span id="iconoarchivoCambioObservaciones" class="iconoValidacion"></span>
                    </div>
                    <button id="observacionesArchivo" type="submit" class="edicionArchivo">Actualizar</button>
                </div>';
    }

    public function procesaFormulario($datos)
    {
        $mensajesFormulario = array();

        $observacionesArchivo = $_REQUEST['observacionesArchivo'];
        $idArchivo = (int)$_REQUEST['id'];
        if (!Archivo::editarObservaciones($idArchivo, $observacionesArchivo)) {
            $mensajesFormulario[] = "Las observaciones no pueden ser las mismas que las antiguas";
            $mensajesFormulario[] = "fracaso";
        }
        else
            echo '<script>document.location.href = "resultadoArchivo.php?id=' . $idArchivo . '";</script>';

        return $mensajesFormulario;
    }
}