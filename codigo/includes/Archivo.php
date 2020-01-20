<?php
require_once __DIR__.'/Aplicacion.php';
require_once __DIR__.'/Universidad.php';
require_once __DIR__.'/Valoracion.php';

class Archivo {
    private static function devuelveInfoArchivo($id){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.id = '%d'"
            , $id);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function size($size){
        while($size >= 1){
            $size = $size / 1024;
        }
        return $size * 1024;
    }

    private static function unit($size){
        $units = ["B", "KB", "MB", "GB"];
        $unit = 0;
        while($size >= 1){
            $size = $size / 1024;
            $unit++;
        }
        if($unit === 0)
            $unit++;
        return $units[$unit - 1];
    }

    public function infoArchivo(){
        echo '<label>Nombre</label>';
        echo '<p>' . $this->nombreArchivo . '</p>';
        echo '<label>Autor</label>';
        echo '<p><a class="autor-archivo" id="' . $this->autor . '" href="perfilAjeno.php?id=' . $this->autor . '">' . $this->autor . '</a></p>';
        echo '<label>Fecha</label>';
        echo '<p>' . substr($this->fecha, 8, 2) . '/' . substr($this->fecha, 5, 2) . '/' . substr($this->fecha, 0, 4) . '</p>';
        echo '<label>Tamaño</label>';
        echo '<p>' . number_format(Archivo::size($this->tamano), 2) . ' ' . Archivo::unit($this->tamano) . '</p>';
        echo '<label>Formato</label>';
        echo '<p>' . $this->formato . '</p>';
        echo '<label>Asignatura</label>';
        echo '<p><a class="asignatura-archivo" id="' . $this->asignatura . '" href="resultadoBuscador.php?asignatura=' . $this->asignatura . '">' . Universidad::obtenerCampoAsignatura($this->asignatura, 'asignatura') . '</a></p>';
        echo '<label>Valoración</label>';
        echo    '<div class="rate" id="rateArchivo">
                    <label for="star1" id="labelstar1"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                    <input class="estrella" type="radio" name="star1" id="star1"/>
                    <label for="star2" id="labelstar2"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                    <input class="estrella" type="radio" name="star2" id="star2"/>
                    <label for="star3" id="labelstar3"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                    <input class="estrella" type="radio" name="star3" id="star3"/>
                    <label for="star4" id="labelstar4"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                    <input class="estrella" type="radio" name="star4" id="star4"/>
                    <label for="star5" id="labelstar5"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                    <input class="estrella" type="radio" name="star5" id="star5"/>
                    <span id="average">(' . Valoracion::devuelveMediaValoracionesArchivo($this->id) . ')</span>
                </div>';
    }

	private static function devuelveArchivosCategoria($asignatura, $categoria){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.asignatura = '%d' AND A.categoria = '%s'"
            , $asignatura
            , $conn->real_escape_string($categoria));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveArchivosUsuario($nombreUsuario){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.autor = '%s'"
            , $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function existenArchivosAsignatura($asignatura) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos WHERE asignatura = '%d' "
            , $asignatura);
        $resultado = $conn->query($query);
        return $resultado->num_rows > 0;
    }

    private static function existenArchivos() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos");
        $resultado = $conn->query($query);
        return $resultado->num_rows > 0;
    }

    private static function devuelveUltimosArchivos(){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A ORDER BY fecha DESC LIMIT 5");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveTodosArchivos(){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }
    
    public static function devuelveNumeroArchivosSubidos($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.autor = '%s'", $conn->real_escape_string($usuario));
        $resultado = $conn->query($query);
        return $resultado->num_rows;
    }

    public static function devuelveArrayArchivosUsuario($nombreUsuario){
        $ids = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos A WHERE A.autor = '%s'"
            , $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        while ($fila = $rs->fetch_assoc()) {
            $archivo = self::devuelveObjetoArchivo($fila['id']);
            $ids[] = $archivo->id . '.' . $archivo->formato;
        }
        $rs->free();
        return $ids;
    }

    public static function devuelveArrayArchivos($ids){
        $archivos = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        foreach ($ids as $id){
            $query = sprintf("SELECT * FROM archivos A WHERE A.asignatura = '%d'", $id);
            $rs = $conn->query($query);
            if (!$rs) {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
            while ($fila = $rs->fetch_assoc()) {
                $archivo = self::devuelveObjetoArchivo($fila['id']);
                $archivos[] = $archivo;
            }
        }
        if (sizeof($ids) > 0)
            $rs->free();
        return $archivos;
    }

    public static function devuelveNumeroArchivosUsuario($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT COUNT(*) AS total FROM archivos A WHERE A.autor = '%s'", $conn->real_escape_string($usuario));
        $result = $conn->query($query);
        $fila = $result->fetch_assoc();
        return $fila['total'];
    }

    public static function generaBusquedaGeneral($asignatura){
        self::crearArchivosZIP($asignatura, '../../');
        $nombreAsignatura = Universidad::obtenerCampoAsignatura($asignatura, 'asignatura');
        $categorias = array("Teoría", "Ejercicios", "Exámenes", "Prácticas");
        $devolver = array();
        $cadena = '';
        foreach($categorias as $categoria){
            $resultado = self::devuelveArchivosCategoria($asignatura, $categoria);
            $cadena = '<h2><a class="categoria" href="resultadoBuscador.php?asignatura=' . $asignatura . '&categoria=' . $categoria . '">' . $categoria . '</a></h2>';
            $i = 0;
            if($resultado->num_rows !== 0){
                while (($fila = $resultado->fetch_assoc()) && $i < 3) {
                    $archivo = self::devuelveObjetoArchivo($fila['id']);
                    $i++;
                    $logo = file_exists("../img/file-logos/logo-" . $archivo->formato . ".png") ? $archivo->formato : 'default';
                    $cadena .= '<div class="resultado-archivo">
                                <a href="resultadoArchivo.php?id=' . $archivo->id . '"><img alt="Logo archivo" src="img/file-logos/logo-' . $logo . '.png"></a>
                                <a class="text" href="resultadoArchivo.php?id=' . $archivo->id . '">' . $archivo->nombreArchivo . '.' . $archivo->formato . '</a>
                                </div>';
                }
                if($resultado->num_rows > 3){
                    $cadena .= '<div class="resultado-archivo" id="more">
                                <a href="resultadoBuscador.php?asignatura=' . $asignatura . '&categoria=' . $categoria . '">Ver más...</a>
                                </div>';
                }
                $i = 0;
                $cadena .= '<div id="div-descargar-zip-categoria">
                                                    <button class="button-descargar-zip" id="button-descargar-zip-' . $categoria . '">ZIP ' . $categoria . '
                                                        <a id="a-descargar-zip-' . $categoria . '" href="zip/asignaturaID' . $asignatura . ' - ' . $categoria . '.zip" download="'. $nombreAsignatura . ' - ' . $categoria . '">
                                                        </a>
                                                    </button>
                                                </div>';
            }
            else
                $cadena .= '<div class="resultado-archivo" id="none">No hay resultados</div>';
            $resultado->free();
            $devolver[$categoria] = $cadena;
            $cadena = '';
        }
        if (Universidad::asignaturaMarcada($asignatura, $_SESSION['nombre']))
            $textoMarcada = 'Desmarcar asignatura';
        else
            $textoMarcada = 'Marcar asignatura';
        $botonesBarraBuscador = '<div id="div-marcar-asignatura">
                                    <button class="button-marcar-asignatura" id="' . $asignatura . '">' . $textoMarcada . '
                                    </button>
                                </div>';
        if(self::existenArchivosAsignatura($asignatura))
            $botonesBarraBuscador .=    '<div id="div-descargar-zip-asignatura">
                                            <button class="button-descargar-zip" id="button-descargar-zip-asignatura">ZIP Asignatura
                                                <a id="a-descargar-zip-asignatura" href="zip/asignaturaID' . $asignatura . '.zip" download="'. $nombreAsignatura . '">
                                                </a>
                                            </button>
                                        </div>';
        $devolver['buscador-selectores'] = $botonesBarraBuscador;
        return $devolver;
    }

    private static function generaBusquedaEspecifica(){
        $categorias = array("Teoría", "Ejercicios", "Exámenes", "Prácticas");
        if (!isset($_GET['asignatura']) || !in_array($_GET['categoria'], $categorias) || !is_numeric($_GET['asignatura']) || !Universidad::existeAsignaturaID($_GET['asignatura'])) {
            echo '<div id="search-not-found">';
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo en la búsqueda salió mal...</p>';
            echo '</div>';
        }
        else {
            $asignatura = $_REQUEST['asignatura'];
            $categoria = $_REQUEST['categoria'];
            $curso = Universidad::obtenerCampoAsignatura($asignatura, 'curso');
            $grado = Universidad::obtenerCampoAsignatura($asignatura, 'grado');
            $facultad = Universidad::obtenerCampoAsignatura($asignatura, 'facultad');
            $nombreAsignatura = Universidad::obtenerCampoAsignatura($asignatura, 'asignatura');
            self::crearArchivosZIP($asignatura, '');
            $cadena = '<h2 id="titulo">' . $categoria . '</h2>';
            $cadena .= '<h4>' . $nombreAsignatura . ' de ' . $curso . ' de ' . $grado . ' de ' . $facultad . '</h4>';
            $resultado = self::devuelveArchivosCategoria($asignatura, $categoria);
            $vacio = true;
            if($resultado->num_rows !== 0){
                $vacio = false;
                $cadena .= '<div class="resultados-categoria">';
                while ($fila = $resultado->fetch_assoc()) {
                    $archivo = self::devuelveObjetoArchivo($fila['id']);
                    $logo = file_exists("img/file-logos/logo-" . $archivo->formato . ".png") ? $archivo->formato : 'default';
                    $cadena .= '<div class="resultado-archivo categoria">
                                <a href="resultadoArchivo.php?id=' . $archivo->id . '"><img alt="Logo archivo" src="img/file-logos/logo-' . $logo . '.png"></a>
                                <a class="text" href="resultadoArchivo.php?id=' . $archivo->id . '">' . $archivo->nombreArchivo . '.' . $archivo->formato . '</a>
                                </div>';
                }
            }
            else {
                $cadena .= '<div class="resultados-categoria" id="none">';
                $cadena .= '<p>No hay resultados</p>';
            }
            $cadena .= '</div>';
            if(!$vacio)
                $cadena .= '<div id="div-descargar-zip-categoria">
                                <button class="button-descargar-zip" id="button-descargar-zip-' . $categoria . '">Descargar ZIP
                                    <a id="a-descargar-zip-' . $categoria . '" href="zip/asignaturaID' . $asignatura . ' - ' . $categoria . '.zip" download="'. $nombreAsignatura . ' - ' . $categoria . '">
                                    </a>
                                </button>
                            </div>';
            $resultado->free();

            echo $cadena;
        }
    }

    public static function generaArchivosUsuario($ultimos, $nombreUsuario){
        if($ultimos)
            $titulo = '<h2>Archivos subidos</h2>';
        else
            if ($nombreUsuario === $_SESSION['nombre'])
                $titulo = '<h1>Mis archivos</h1>';
            else
                $titulo = '<h1>Archivos subidos por ' . $nombreUsuario . '</h1>';
        $html = $titulo;
        $resultado = self::devuelveArchivosUsuario($nombreUsuario);
        $html .= $ultimos && $resultado->num_rows > 3 ? '<a href="perfilAjeno.php?id=' . $nombreUsuario . '&caso=archivos"><button id="todosArchivosUsuario">Ver todos los archivos subidos por ' . $nombreUsuario . '</button></a>' : '';
        if($resultado->num_rows !== 0) {
            $html .= '<div class="item-archivo" id="header">
                        <div class="nombre-archivo">
                            <label id="header">Nombre</label>
                        </div>
                        <div class="observaciones-archivo">
                            <label id="header">Observaciones</label>
                        </div>
                        <div class="fecha-archivo">
                            <label id="header">Fecha</label>
                        </div>
                        <div class="tamanio-archivo">
                            <label id="header">Tamaño</label>
                        </div>
                        <div class="formato-archivo">
                            <label id="header">Formato</label>
                        </div>
                      </div>';
            $i = 0;
            while (($fila = $resultado->fetch_assoc()) && ($i < 3 || !$ultimos)) {
                $archivo = self::devuelveObjetoArchivo($fila['id']);
                $html .= '<div class="item-archivo" id="' . $archivo->id . '">
                            <div class="nombre-archivo">
                                <label><a id="' . $archivo->id . '" href="resultadoArchivo.php?id=' . $archivo->id . '" class="file">' . $archivo->nombreArchivo . '</a></label>
                            </div>
                            <div class="observaciones-archivo">
                                <label> ' . $archivo->observaciones . '</label>
                            </div>
                            <div class="fecha-archivo">
                                <label> ' . substr($archivo->fecha, 8, 2) . '/' . substr($archivo->fecha, 5, 2) . '/' . substr($archivo->fecha, 0, 4) . '</label>
                            </div>
                            <div class="tamanio-archivo">
                                <label> ' . number_format(Archivo::size($archivo->tamano), 2) . ' ' . Archivo::unit($archivo->tamano) . '</label>
                            </div>
                            <div class="formato-archivo">
                                <label> ' . $archivo->formato . '</label>
                            </div>
                          </div>';
                $i++;
            }
        }
        else
            $html .= '<p>Aún no has subido ningún archivo';
        $resultado->free();

        return $html;
    }

    public static function generaTodosArchivos($ultimos){
        $html = '';
        $html .= $ultimos ? '<h2>Últimos archivos subidos</h2>' : '<h1>Archivos de la base de datos</h1>';
        $html .= $ultimos && self::existenArchivos() ? '<a href="apuntesAdministrador.php"><button id="todosArchivos">Ver todos los archivos</button></a>' : '';
        $resultado = $ultimos ? self::devuelveUltimosArchivos() : self::devuelveTodosArchivos();
        if($resultado->num_rows !== 0) {
            $html .= '<div class="item-archivo" id="header">
                        <div class="nombre-archivo">
                            <label id="header">Nombre</label>
                        </div>
                        <div class="observaciones-archivo">
                            <label id="header">Observaciones</label>
                        </div>
                        <div class="fecha-archivo">
                            <label id="header">Fecha</label>
                        </div>
                        <div class="autor-archivo">
                            <label id="header">Autor</label>
                        </div>
                        <div class="formato-archivo">
                            <label id="header">Formato</label>
                        </div>
                        </div>';
            while ($fila = $resultado->fetch_assoc()) {
                $archivo = self::devuelveObjetoArchivo($fila['id']);
                $html .= '<div class="item-archivo" id="' . $archivo->id . '">
                            <div class="nombre-archivo">
                                <label> <a id="' . $archivo->id . '" href="resultadoArchivo.php?id=' . $archivo->id . '" class="file">' . $archivo->nombreArchivo . '</a></label>
                            </div>
                            <div class="observaciones-archivo">
                                <label> ' . $archivo->observaciones . '</label>
                            </div>
                            <div class="fecha-archivo">
                                <label> ' . substr($archivo->fecha, 8, 2) . '/' . substr($archivo->fecha, 5, 2) . '/' . substr($archivo->fecha, 0, 4) . '</label>
                            </div>
                            <div class="autor-archivo">
                                <label><a id="' . $archivo->autor . '" href="perfilAjeno.php?id=' . $archivo->autor . '" class="autor">' . $archivo->autor . '</a></label>
                            </div>
                            <div class="formato-archivo">
                                <label> ' . $archivo->formato . '</label>
                            </div>
                            </div>';
            }
        }
        else
            $html .= '<p>No hay archivos en la base de datos';
        $resultado->free();

        return $html;
    }

    public static function editarArchivo(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !$archivo = self::devuelveObjetoArchivo((int)$_GET['id'])){
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
        }
        else {
            $id = (int)$_GET['id'];
            echo "<h1>" . $archivo->nombreArchivo . "</h1>";
            echo '<div id="divMensajes">';
            echo '</div>';
            echo "<div class='form-nombreArchivo'>";
            echo "<h3>Cambiar nombre del archivo</h3>";
            $formularioNombreArchivo = new FormularioNombreArchivo("form-nombreArchivo", array( 'action' => 'editarArchivo.php?id=' . $id));
            $formularioNombreArchivo->gestiona();
            echo "</div>";
            echo "<div class='form-observacionesArchivo'>";
            echo "<h3>Cambiar observaciones del archivo</h3>";
            $formularioObservacionesArchivo = new FormularioObservacionesArchivo("form-observacionesArchivo", array( 'action' => 'editarArchivo.php?id=' . $id));
            $formularioObservacionesArchivo->gestiona();
            echo "</div>";
        }
    }

    public static function editarObservaciones($id, $observacionesArchivo) {
        $archivo = Archivo::devuelveObjetoArchivo($id);
        if ($archivo->observaciones !== $observacionesArchivo) {
            $archivo->observaciones = $observacionesArchivo;
            self::cambiarObservaciones($archivo);
            return true;
        }
        else
            return false;
    }

    public static function editarNombre($id, $nombreArchivo) {
        $archivo = Archivo::devuelveObjetoArchivo($id);
        if ($archivo->nombreArchivo !== $nombreArchivo) {
            $archivo->nombreArchivo = $nombreArchivo;
            self::cambiarNombre($archivo);
            return true;
        }
        else
            return false;
    }
	
	private static function cambiarNombre($archivo){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE archivos A SET nombreArchivo = '%s' WHERE A.id = '%d'"
            , $conn->real_escape_string($archivo->nombreArchivo . '.' . $archivo->formato)
            , $archivo->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el nombre: " . $archivo->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    private static function cambiarObservaciones($archivo){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("UPDATE archivos A SET observaciones = '%s' WHERE A.id = '%d'"
            , $conn->real_escape_string($archivo->observaciones)
            , $archivo->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el nombre: " . $archivo->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
    
    public static function crea($nombreArchivo, $categoria, $asignatura, $autor, $observaciones, $tamano, $fecha, $formato){
        $archivo = new Archivo($nombreArchivo, $categoria, $asignatura, $autor, $observaciones, $tamano, $fecha, $formato);
        if(Universidad::zipAsignaturaActualizado($asignatura))
            Universidad::cambiarZIPAsignatura($asignatura, 0);
        return self::inserta($archivo);
    }
    
    private static function inserta($archivo){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("INSERT INTO archivos(nombreArchivo, categoria, asignatura, autor, observaciones, tamano, fecha) VALUES('%s', '%s', '%d', '%s', '%s', '%d', '%s')"
            , $conn->real_escape_string($archivo->nombreArchivo . '.' . $archivo->formato)
            , $conn->real_escape_string($archivo->categoria)
            , $conn->real_escape_string($archivo->asignatura)
			, $conn->real_escape_string($archivo->autor)
			, $conn->real_escape_string($archivo->observaciones)
			, $archivo->tamano
			, $conn->real_escape_string($archivo->fecha));
        if ( $conn->query($query) ) {
            $archivo->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $archivo;
    }
    
    private $id;

    private $nombreArchivo;

    private $categoria;

    private $asignatura;
	
	private $autor;
	
	private $observaciones;
	
	private $tamano;
	
	private $fecha;
	
    private $formato;

    private function __construct($nombreArchivo, $categoria, $asignatura, $autor, $observaciones, $tamano, $fecha, $formato){
        $this->nombreArchivo = $nombreArchivo;
        $this->categoria = $categoria;
        $this->asignatura = $asignatura;
        $this->autor = $autor;
        $this->observaciones = $observaciones;
		$this->tamano = $tamano;
		$this->fecha = $fecha;
        $this->formato = $formato;
    }

    public static function devuelveObjetoArchivo($id){
        $resultado = Archivo::devuelveInfoArchivo($id);
        $existe = false;
        if ($resultado->num_rows == 1) {
            $info = $resultado->fetch_assoc();
            $nombreArchivo = $info["nombreArchivo"];
            $arrayNombreArchivo = explode('.', $nombreArchivo);
            $extensionArchivo = end($arrayNombreArchivo);
            $nombreArchivo = $arrayNombreArchivo[0];
            $archivo = new Archivo($nombreArchivo, $info["categoria"], $info["asignatura"], $info["autor"], $info["observaciones"], $info["tamano"], $info["fecha"], $extensionArchivo);
            $existe = $archivo;
            $archivo->id = $id;
        }
        $resultado->free();
        return $existe;
    }

    public static function devuelveAutorArchivo($archivo){
        return $archivo->autor();
    }

    public static function generarResultadoBusqueda(){
        if(isset($_GET['categoria']))
            self::generaBusquedaEspecifica();
        else
            self::generaBusquedaAsignatura();
    }

    private static function generaBusquedaAsignatura(){
        if (!isset($_GET['asignatura']) || !is_numeric($_GET['asignatura']) || !Universidad::existeAsignaturaID($_GET['asignatura'])) {
            echo '<div id="search-not-found">';
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo en la búsqueda salió mal...</p>';
            echo '</div>';
        }
        else {
            $asignatura = $_REQUEST['asignatura'];
            self::crearArchivosZIP($asignatura, '');
            $nombreAsignatura = Universidad::obtenerCampoAsignatura($asignatura, 'asignatura');
            $categorias = array("Teoría", "Ejercicios", "Prácticas", "Exámenes");
            $vacio = true;
            $curso = Universidad::obtenerCampoAsignatura($asignatura, 'curso');
            $grado = Universidad::obtenerCampoAsignatura($asignatura, 'grado');
            $facultad = Universidad::obtenerCampoAsignatura($asignatura, 'facultad');
            $cadena = '<h1>' . $nombreAsignatura . '</h1>';
            if(self::existenArchivosAsignatura($asignatura))
                $cadena .= '<div id="div-descargar-zip-asignatura">
                                <button class="button-descargar-zip" id="button-descargar-zip-asignatura-general">Descargar ZIP
                                    <a id="a-descargar-zip-asignatura" href="zip/asignaturaID' . $asignatura . '.zip" download="'. $nombreAsignatura . '">
                                    </a>
                                </button>
                            </div>';
            $cadena .= '<div class="busqueda">';
            foreach($categorias as $categoria){
                $resultado = self::devuelveArchivosCategoria($asignatura, $categoria);
                $cadena .= '<div class="resultadosGeneral buscador" id="' . $categoria . '">';
                $cadena .= '<h2><a class="categoria" href="resultadoBuscador.php?asignatura=' . $asignatura . '&categoria=' . $categoria . '">' . $categoria . '</a></h2>';
                $i = 0;
                if($resultado->num_rows !== 0){
                    $vacio = false;
                    while (($fila = $resultado->fetch_assoc()) && $i < 3) {
                        $archivo = self::devuelveObjetoArchivo($fila['id']);
                        $i++;
                        $logo = file_exists("img/file-logos/logo-" . $archivo->formato . ".png") ? $archivo->formato : 'default';
                        $cadena .= '<div class="resultado-archivo">
                                    <a href="resultadoArchivo.php?id=' . $archivo->id . '"><img alt="Logo archivo" src="img/file-logos/logo-' . $logo . '.png"></a>
                                    <a class="text" href="resultadoArchivo.php?id=' . $archivo->id . '">' . $archivo->nombreArchivo . '.' . $archivo->formato . '</a>
                                    </div>';
                    }
                    if($resultado->num_rows > 3){
                        $cadena .= '<div class="resultado-archivo" id="more">
                                    <a href="resultadoBuscador.php?asignatura=' . $asignatura . '&categoria=' . $categoria . '">Ver más...</a>
                                    </div>';
                    }
                    $i = 0;
                    $cadena .= '<div id="div-descargar-zip-categoria">
                                    <button class="button-descargar-zip" id="button-descargar-zip-' . $categoria . '">ZIP ' . $categoria . '
                                        <a id="a-descargar-zip-' . $categoria . '" href="zip/asignaturaID' . $asignatura . ' - ' . $categoria . '.zip" download="'. $nombreAsignatura . ' - ' . $categoria . '">
                                        </a>
                                    </button>
                                </div>';
                }
                else
                    $cadena .= '<div class="resultado-archivo" id="none">No hay resultados</div>';
                $resultado->free();
                $cadena .= '</div>';
            }
            $cadena .= '</div>';
            echo $cadena;
        }
    }

    public static function generarResultadoArchivo(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !$archivo = self::devuelveObjetoArchivo((int)$_GET['id'])){
            echo '<div id="file-not-found">';
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
            echo '</div>';
        }
        else {
            $id = (int)$_REQUEST['id'];
            echo '<div id="archivo">';
            echo '<div id="preview-info">';
            echo '<div id="file-preview">';
            $formato = $archivo->formato() === 'jpg' || $archivo->formato() === 'png' || $archivo->formato() === 'pdf';
            $src = $formato ? 'data/archivos/' . $archivo->id() . '.' . $archivo->formato() : 'img/file-logos/logo-default.png';
            echo '<embed id="' . $id . '" class="embed" src="' . $src . '" />';
            echo '</div>';
            echo '<div id="file-info">';
            echo '<div id="file-info-contenido">';
            if ($archivo->autor === $_SESSION['nombre'] || $_SESSION['esAdmin']){
                echo '<div id="editor">';
                echo '<a data-objeto="archivo" data-accion="editar" class="editor" id="' . $id . '"><i class="fa fa-edit"></i></a>';
                echo '<a data-objeto="archivo" data-accion="borrar" class="editor" id="' . $id . '"><i class="fa fa-trash"></i></a>';
                echo '</div>';
            }
            echo '<div id="button-descargar-archivo">';
            echo '<button id="button-descargar-archivo"><i class="fa fa-download"></i> Descargar
                                                            <a id="a-descargar-archivo" href="data/archivos/' . $archivo->id() . '.' . $archivo->formato() . '" download="'. $archivo->nombre() . '.' . $archivo->formato() . '">
                                                            </a>
                                                        </button>';
            echo '</div>';
            $archivo->infoArchivo();
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div id="observaciones-file">';
            echo '<h2>Observaciones del autor:</h2>';
            echo '<div id="observaciones-text">';
            if($archivo->observaciones() !== '')
                echo '<p>' . $archivo->observaciones() . '</p>';
            else
                echo '<p>El autor no ha añadido observaciones sobre este archivo.</p>';
            echo '</div>';
            echo '</div>';
            echo '<div id="reporte-file">';
            echo '<h2>Generar reporte sobre el archivo:</h2>';
            $formularioReporte = new FormularioReporte("form-reporte-archivo", array( 'action' => 'resultadoArchivo.php?id=' . $id));
            $formularioReporte->gestiona();
            echo '</div>';
            echo '</div>';
        }
    }

    public static function borrarArchivo($id){
        $archivo = self::devuelveObjetoArchivo($id);
        $nombreArchivo = $archivo->id . '.' . $archivo->formato;
        if ($archivo->autor === $_SESSION['nombre'] || $_SESSION['esAdmin']) {
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $query = sprintf("DELETE FROM archivos WHERE id = '%d'", $id);
            if ( !$conn->query($query) ) {
                echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
            unlink('../../data/archivos/' . $nombreArchivo);
        }
        if(Universidad::zipAsignaturaActualizado($archivo->asignatura()))
            Universidad::cambiarZIPAsignatura($archivo->asignatura(), 0);
    }

    private static function crearArchivosZIP($asignatura, $prepath){
        if(!Universidad::zipAsignaturaActualizado($asignatura) && self::existenArchivosAsignatura($asignatura)){
            $nombreAsignatura = Universidad::obtenerCampoAsignatura($asignatura, 'asignatura');
            $zipAsignatura = new ZipArchive;
            if(!file_exists($prepath . 'zip/'))
                mkdir($prepath . 'zip');
            if ($zipAsignatura->open($prepath . 'zip/asignaturaID' . $asignatura . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
            {
                $path = $prepath . 'data/archivos';
                $dir = opendir($path);
                $categorias = ['Teoría', 'Prácticas', 'Exámenes', 'Ejercicios'];
                foreach($categorias as $categoria){
                    $zipCategoria = new ZipArchive;
                    if ($zipCategoria->open($prepath . 'zip/asignaturaID' . $asignatura . ' - ' . $categoria . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE){
                        $resultado = self::devuelveArchivosCategoria($asignatura, $categoria);
                        while ($fila = $resultado->fetch_assoc()){
                            $archivo = self::devuelveObjetoArchivo($fila['id']);
                            $zipAsignatura->addFile($path . '/' . $archivo->id . '.' . $archivo->formato, $nombreAsignatura . '/' . $categoria . '/' . $archivo->id . '-' . $archivo->nombreArchivo . '.' . $archivo->formato);
                            $zipCategoria->addFile($path . '/' . $archivo->id . '.' . $archivo->formato, $nombreAsignatura . ' - ' . $categoria . '/' . $archivo->id . '-' . $archivo->nombreArchivo . '.' . $archivo->formato);
                        }
                        $zipCategoria->close();
                    }
                }
                closedir($dir);
                $zipAsignatura->close();
            }
            Universidad::cambiarZIPAsignatura($asignatura, 1);
        }
    }

    public function id(){
        return $this->id;
    }

    public function nombre(){
        return $this->nombreArchivo;
    }

    public function asignatura(){
        return $this->asignatura;
    }
    
    public function categoria(){
        return $this->categoria;
    }

    public function formato(){
        return $this->formato;
    }

    public function observaciones(){
        return $this->observaciones;
    }

    public function autor(){
        return $this->autor;
    }
}
