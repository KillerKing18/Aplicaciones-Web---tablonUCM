<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Universidad.php';
require_once __DIR__.'/../Archivo.php';
require_once __DIR__.'/../Novedad.php';

class FormularioUpload extends Form {

    public function generaCamposFormulario($datosIniciales)
    {
		$options = Universidad::creaOpcionesGenerico('', '', '', 'una facultad', 'facultades', true);
        $allowedExtensions = ".jpeg, .jpg, .png, .pdf, .doc, .docm, .docx, .ppt, .pptm, .pptx, .sql, .xls, .xlsm, .xlsx, .rar, .zip, .txt";
        return  '   <div id="file-upload">
                        <input type="text" id="upload-selected" placeholder="Ningún archivo seleccionado" disabled></input>
                        <input accept="' . $allowedExtensions . '" type="file" id="archivo" name="archivo" required>
                        <button id="examinar">Examinar</button>
                    </div>
                    <div id="info-file-upload">
                        <div id="selectores-upload">
                            <label>Facultad</label>
                            <select name="facultad" class="selector" id="facultad" required>'
                            . $options .
                            '</select>
                            <label>Grado</label>
                            <select name="grado" class="selector" id="grado" disabled required>
                                <option value="" disabled selected>Elija un grado</option>
                            </select>
                            <label>Curso</label>
                            <select name="curso" class="selector" id="curso" disabled required>
                                <option value="" disabled selected>Elija un curso</option>
                            </select>
                            <label>Asignatura</label>
                            <select name="asignatura" class="selector" id="asignatura" disabled required>
                                <option value="" disabled selected>Elija una asignatura</option>
                            </select>
                            <label>Categoría</label>
                            <select name="categoria" class="selector" id="categoria" disabled required>
                                <option value="" disabled selected>Elija una categoría</option>
                            </select>
                        </div>
                        <div id="observaciones">
                            <p>Sólo se puede subir 1 único archivo. Si necesitas subir varios archivos para que tu contenido sea
                            consistente, puedes comprimirlos en un archivo .zip o .rar </p>    
                            <label>Observaciones</label>
                            <textarea rows="4" name="observaciones" maxlength="140"></textarea>
                            <div id="submit-button">
                                <button type="submit" id="subir">Subir</button>
                            </div>
                        </div>
                    </div>';
    }

    public function procesaFormulario($datos)
    { 
        $mensajesFormulario = array();

        $file_name = htmlspecialchars(trim(strip_tags($_FILES['archivo']['name'])));
        $file_name_array = explode('.', $file_name);
        $file_ext = strtolower(end($file_name_array));
        $file_name = $file_name_array[0];
        $file_size = (int)$_FILES['archivo']['size'];

        if($file_size > 2097152){
            $mensajesFormulario[] = "El tamaño máximo permitido para un archivo es de 2MB";
            $mensajesFormulario[] = "fracaso";
        }
        else if ((int)Archivo::devuelveNumeroArchivosUsuario($_SESSION['nombre']) > 45){
            $mensajesFormulario[] = "El número máximo de archivos que puedes subir es de 45";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            $file_tmp = $_FILES['archivo']['tmp_name'];

            $finfo = new finfo(FILEINFO_MIME);
            $type = $finfo->file($file_tmp);
            if ((substr($type, 0, 5) === 'image') || ($type === 'application/zip; charset=binary') || ($type === 'application/x-rar-compressed; charset=binary') 
            || ($type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=binary') || ($type === 'text/plain; charset=us-ascii')
            || ($type === 'application/vnd.ms-excel.sheet.macroenabled.12; charset=binary') || ($type === 'text/x-Algol68; charset=utf-8')
            || ($type === 'application/vnd.ms-excel; charset=binary') || ($type === 'text/plain; charset=utf-8') 
            || ($type === 'text/plain; charset=binary') || ($type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation; charset=binary') 
            || ($type === 'application/vnd.ms-powerpoint.presentation.macroenabled.12; charset=binary') || ($type === 'application/vnd.ms-powerpoint; charset=binary') 
            || ($type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document; charset=binary') || ($type === 'application/pdf; charset=binary') 
            || ($type === 'application/msword; charset=binary') || ($type === 'application/vnd.ms-word.document.macroenabled.12; charset=binary')){
                $asignatura = (int)$_REQUEST['asignatura'];
                $categoria = $_REQUEST['categoria'];
                $observaciones = htmlspecialchars(trim(strip_tags($_REQUEST['observaciones'])));

                $carpeta = 'data/archivos';

                if (!file_exists('data/'))
                    mkdir('data');
                if (!file_exists($carpeta . '/'))
                    mkdir('data/archivos');

                $archivo = Archivo::crea($file_name, $categoria, $asignatura, $_SESSION['nombre'], $observaciones, $file_size, date("Y-m-d H:i:s"), $file_ext);
                
                if(!move_uploaded_file($file_tmp, $carpeta . '/' . $archivo->id() . '.' . $file_ext)) {
                    $mensajesFormulario[] = "Se ha producido un error al subir el archivo";
                    $mensajesFormulario[] = "fracaso";
                }
                else {
                    Novedad::crearNovedad('novedadesarchivos', 'idArchivo', $archivo->id());
                    echo '<script>document.location.href = "resultadoArchivo.php?id=' . $archivo->id() . '";</script>';
                }
            }
            else {
                $mensajesFormulario[] = "Debes subir un tipo de archivo válido";
                $mensajesFormulario[] = "fracaso";
            }
        }

        return $mensajesFormulario;
    }

}