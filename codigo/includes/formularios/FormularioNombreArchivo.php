<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Archivo.php';

class FormularioNombreArchivo extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<label>Nuevo nombre del archivo:</label>
                <div id="camposNombreArchivo">
                    <div id="inputIconoCambioNombre">
                        <input data-id-archivo="' . (int)$_GET['id'] . '" class="validacion" type="text" name="nombreArchivo" id="archivoCambioNombre" maxlength="80" required><span id="iconoarchivoCambioNombre" class="iconoValidacion"></span>
                    </div>
                    <button id="nombreArchivo" type="submit" class="edicionArchivo">Actualizar</button>
                </div>';
    }

    public function procesaFormulario($datos)
    {
        $mensajesFormulario = array();

        $nombreArchivo = $_REQUEST['nombreArchivo'];
        $idArchivo = (int)$_GET['id'];
        if (!Archivo::editarNombre($idArchivo, $nombreArchivo)) {
            $mensajesFormulario[] = "El nuevo nombre no puede ser el mismo que el antiguo";
            $mensajesFormulario[] = "fracaso";
        }
        else
            echo '<script>document.location.href = "resultadoArchivo.php?id=' . $idArchivo . '";</script>';

        return $mensajesFormulario;
    }
}