<?php
require_once __DIR__.'/Aplicacion.php';

class Evento
{
    public static function borrarEvento($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM eventos WHERE id = '%d'", $id);
        if ( !$conn->query($query) ) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
    
    public static function crea($nombreEvento, $categoria, $lugar, $fecha, $hora, $creador, $descripcion) {
        $evento = new Evento($nombreEvento, $categoria, $lugar, $fecha, $hora, $creador, $descripcion);
		
        return self::inserta($evento);
    }
    
    private static function inserta($evento) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO eventos(nombre, categoria, lugar, fecha, creador, descripcion) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($evento->nombreEvento)
            , $conn->real_escape_string($evento->categoria)
            , $conn->real_escape_string($evento->lugar)
            , $conn->real_escape_string($evento->fecha . ' ' . $evento->hora)
			, $conn->real_escape_string($evento->creador)
			, $conn->real_escape_string($evento->descripcion));
        if ( $conn->query($query) ) {
            $evento->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $evento;
    }

    public static function editarNombre($id, $nombreEvento) {
        $evento = Evento::devuelveObjetoEvento($id);
        if ($evento->nombreEvento !== $nombreEvento) {
            $evento->nombreEvento = $nombreEvento;
            self::cambiarNombre($evento);
            return true;
        }
        else
            return false;
    }

    public static function editarDescripcion($id, $descripcion) {
        $evento = Evento::devuelveObjetoEvento($id);
        if ($evento->descripcion !== $descripcion) {
            $evento->descripcion = $descripcion;
            self::cambiarDescripcion($evento);
            return true;
        }
        else
            return false;
    }

    public static function editarLugar($id, $lugar) {
        $evento = Evento::devuelveObjetoEvento($id);
        if ($evento->lugar !== $lugar) {
            $evento->lugar = $lugar;
            self::cambiarLugar($evento);
            return true;
        }
        else
            return false;
    }

    public static function editarFecha($id, $fechaEvento) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("UPDATE eventos E SET fecha='%s' WHERE E.id='%d'"
            , $conn->real_escape_string($fechaEvento)
            , $id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la fecha: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    private static function cambiarNombre($evento){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE eventos E SET nombre = '%s' WHERE E.id = '%d'"
            , $conn->real_escape_string($evento->nombreEvento)
            , $evento->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el nombre: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    private static function cambiarDescripcion($evento){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE eventos E SET descripcion = '%s' WHERE E.id = '%d'"
            , $conn->real_escape_string($evento->descripcion)
            , $evento->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la descripción: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    private static function cambiarLugar($evento) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("UPDATE eventos E SET lugar='%s' WHERE E.id='%d'"
            , $conn->real_escape_string($evento->lugar)
            , $evento->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el lugar: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
	
	private static function cambiarhora($evento) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE eventos E SET hora='%s' WHERE E.id='%d'"
            , $conn->real_escape_string($evento->hora)
            , $evento->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la hora: " . $evento->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $evento;
    }
    
    private $id;

    private $nombreEvento;

    private $categoria;

    private $lugar;

    private $fecha;
	
	private $hora;
	
	private $creador;
	
	private $descripcion;

    private function __construct($nombreEvento, $categoria, $lugar, $fecha, $hora, $creador, $descripcion) {
        $this->nombreEvento= $nombreEvento;
        $this->categoria = $categoria;
        $this->lugar = $lugar;
        $this->fecha = $fecha;
		$this->hora= $hora;
        $this->creador = $creador;
        $this->descripcion = $descripcion;
    }

    public function id() {
        return $this->id;
    }

    public function nombre() {
        return $this->nombreEvento;
    }

    public function lugar() {
        return $this->lugar;
    }

    public function descripcion() {
        return $this->descripcion;
    }

    public function creador() {
        return $this->creador;
    }

    public static function creaOpcionesCategoria(){
        $options = '<option value="" disabled selected>Elija una categoría</option>';
        $options .= '<option value="Estudio">Estudio</option>';
        $options .= '<option value="Deporte">Deporte</option>';
        $options .= '<option value="Música">Música</option>';
        $options .= '<option value="Acontecimiento">Acontecimiento</option>';
        return $options;
    }

    public static function creaOpcionesHora(){
        $options = '<option value="" disabled selected>Elija una hora</option>';
        $options .= '<option value="00:00">00:00</option>';
        $options .= '<option value="01:00">01:00</option>';
        $options .= '<option value="02:00">02:00</option>';
        $options .= '<option value="03:00">03:00</option>';
        $options .= '<option value="04:00">04:00</option>';
        $options .= '<option value="05:00">05:00</option>';
        $options .= '<option value="06:00">06:00</option>';
        $options .= '<option value="07:00">07:00</option>';
        $options .= '<option value="08:00">08:00</option>';
        $options .= '<option value="09:00">09:00</option>';
        $options .= '<option value="10:00">10:00</option>';
        $options .= '<option value="11:00">11:00</option>';
        $options .= '<option value="12:00">12:00</option>';
        $options .= '<option value="13:00">13:00</option>';
        $options .= '<option value="14:00">14:00</option>';
        $options .= '<option value="15:00">15:00</option>';
        $options .= '<option value="16:00">16:00</option>';
        $options .= '<option value="17:00">17:00</option>';
        $options .= '<option value="18:00">18:00</option>';
        $options .= '<option value="19:00">19:00</option>';
        $options .= '<option value="20:00">20:00</option>';
        $options .= '<option value="21:00">21:00</option>';
        $options .= '<option value="22:00">22:00</option>';
        $options .= '<option value="23:00">23:00</option>';
        return $options;
    }

    public static function insertaAsistenteEvento($id){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO asistentes (idEvento, idUsuario) VALUES ('%d', '%s')"
            , $id
            , $conn->real_escape_string($_SESSION['nombre']));
        return $conn->query($query);
    }

    public static function quitaAsistenteEvento($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM asistentes WHERE idEvento = '%d' AND idUsuario ='%s'"
            , $id
            , $conn->real_escape_string($_SESSION['nombre']));
        if ( !$conn->query($query) ) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function devuelveAsistentesEvento($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT COUNT(*) AS total FROM asistentes A WHERE A.idEvento = '%d'", $id);
        $result = $conn->query($query);
        $fila = $result->fetch_assoc();
        return $fila['total'];
    }

    public static function apuntadoAEvento($idEvento, $idUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM asistentes WHERE idEvento = '%d' AND idUsuario = '%s'"
            , $idEvento
            , $conn->real_escape_string($idUsuario));
        $resultado = $conn->query($query);
        return $resultado->num_rows === 1;
    }

    public static function mostrarEvento(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !$evento = self::devuelveObjetoEvento((int)$_GET['id'])) {
            echo '<div id="search-not-found">';
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
            echo '</div>';
        }
        else {
            if (self::apuntadoAEvento($evento->id, $_SESSION['nombre']))
                $textoApuntarse = 'No asistiré';
            else
                $textoApuntarse = 'Asistiré';
            echo '<div id="display-evento">';
            echo    '<h1 class="titulo" id="' . $evento->id . '">' . $evento->nombreEvento . '</h1>';
            echo    '<div id="foto-datos-evento">';
            echo        '<img alt="Foto ' . $evento->categoria . '" src="img/eventos/' . $evento->categoria . '.png">';
            echo        '<div id="boton-datos-evento">';
            if ($evento->creador === $_SESSION['nombre'] || $_SESSION['esAdmin']){
                echo        '<div id="editor">';
                echo            '<a data-objeto="evento" data-accion="editar" class="editor" id="' . $evento->id . '"><i class="fa fa-edit"></i></a>';
                echo            '<a data-objeto="evento" data-accion="borrar" class="editor" id="' . $evento->id . '"><i class="fa fa-trash"></i></a>';
                echo        '</div>';
            }
            echo            '<button id="apuntarEvento">' . $textoApuntarse . '</button>';
            echo            '<div id="datos-evento">';
            echo                '<label>Fecha y hora: </label>';
            echo                '<p>' . $evento->fecha . ' a las ' . $evento->hora . '</p>';
            echo                '<label>Lugar: </label>';
            echo                '<p><a class="lugar-evento" id="' . $evento->lugar . '" href="https://www.google.es/maps/search/' . $evento->lugar . '">' . $evento->lugar . '</a></p>';
            echo                '<label>Categoría: </label>';
            echo                '<p><a class="categoria-evento" id="' . $evento->categoria . '" href="eventos.php?categoria=' . $evento->categoria . '">' . $evento->categoria . '</a></p>';
            echo                '<label>Asistentes: </label>';
            echo                '<p id="asistentes">' . self::devuelveAsistentesEvento($evento->id) . '</p>';
            echo                '<label>Creador: </label>';
            echo                '<p><a class="creador-evento" id="' . $evento->creador . '" href="perfilAjeno.php?id=' . $evento->creador . '">' . $evento->creador . '</a></p>';
            echo            '</div>';
            echo        '</div>';
            echo    '</div>';
            echo    '<div id="descripcion-evento">';
            echo        '<h2>Descripción:</h2>';
            echo        '<div id="descripcion-text">';
            echo            '<p>' . $evento->descripcion . '</p>';
            echo        '</div>';
            echo    '</div>';
            echo    '<div id="reporte-event">';
            echo        '<h2>Generar reporte sobre el evento:</h2>';
            $formularioReporte = new FormularioReporte("form-reporte-evento", array( 'action' => 'resultadoEvento.php?id=' . $evento->id));
            $formularioReporte->gestiona();
            echo '  </div>';
            echo '</div>';
        }
    }

    private static function devuelveInfoEvento($id){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos E WHERE E.id = '%d'"
            , $id);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function devuelveCreadorEvento($evento){
        return $evento->creador();
    }

    public static function devuelveObjetoEvento($id){
        $resultado = self::devuelveInfoEvento($id);
        $existe = false;
        if ($resultado->num_rows == 1) {
            $info = $resultado->fetch_assoc();
            $evento = new Evento($info["nombre"], $info["categoria"], $info["lugar"], substr($info["fecha"], 8, 2) . '/' . substr($info["fecha"], 5, 2) . '/' . substr($info["fecha"], 0, 4), substr($info["fecha"], 11, 8), $info["creador"], $info["descripcion"]);
            $existe = $evento;
            $evento->id = $id;
        }
        $resultado->free();
        return $existe;
    }

    private static function devuelveTodosEventos(){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos ORDER BY fecha DESC");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveEventosApuntados($usuario){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos WHERE id IN (SELECT idEvento FROM asistentes WHERE idUsuario = '%s')", $usuario);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveEventosCreados($usuario){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos E WHERE E.creador = '%s'", $conn->real_escape_string($usuario));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveUltimosEventosCreados($usuario){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos E WHERE E.creador = '%s' LIMIT 3", $conn->real_escape_string($usuario));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveEventosCategoria($categoria){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos E WHERE E.categoria = '%s'", $conn->real_escape_string($categoria));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveProximosEventos(){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos ORDER BY fecha ASC LIMIT 3");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function borrarEventos($nombreUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM eventos WHERE creador = '%s'", $conn->real_escape_string($nombreUsuario));
        if ( !$conn->query($query) ) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function mostrarEventos($caso, $ultimos, $usuario){
        switch ($caso){
            case 'general':
                $resultado = self::devuelveTodosEventos();
                if($ultimos)
                    $titulo = '<h2>Próximos eventos</h2>';
                else
                    $titulo = '<h1 id="titulo-evento-secundario">Todos los eventos</h1>';
                break;
            case 'apuntados':
                $resultado = self::devuelveEventosApuntados($usuario);
                if($ultimos)
                    $titulo = '<h2>Eventos a los que estás apuntado</h2>';
                else
                    $titulo = '<h1 id="titulo-evento-secundario">Eventos a los que estás apuntado</h1>';
                break;
            case 'creados':
                $creador = $usuario === $_SESSION['nombre'] ? 'ti' : $usuario;
                $textoTitulo = 'Eventos creados por ' . $creador;
                
                $resultado = self::devuelveEventosCreados($usuario);
                if($ultimos)
                    $titulo = '<h2>' . $textoTitulo . '</h2>';
                else
                    $titulo = '<h1 id="titulo-evento-secundario">' . $textoTitulo . '</h1>';
                break;
            case 'categoria':
                $resultado = self::devuelveEventosCategoria($_REQUEST['categoria']);
                $plural = $_REQUEST['categoria'] === 'Música' ? '' : 's';
                $titulo = '<h1 id="titulo-evento-secundario">Eventos de ' . $_REQUEST['categoria'] . $plural . '</h1>';
                break;
        }
        return self::mostrarEventosCaso($caso, $usuario, $resultado, $titulo, $ultimos);
    }

    public static function mostrarResultadoEventos(){
        $categorias = array("Estudio", "Deporte", "Música", "Acontecimiento");
        if ((!isset($_GET['caso']) && isset($_GET['usuario'])) || (isset($_GET['caso']) && $_GET['caso'] === 'creados' && !isset($_GET['usuario'])) || (isset($_GET['caso']) && $_GET['caso'] === 'todos' && isset($_GET['usuario'])) || (isset($_GET['usuario']) && isset($_GET['categoria'])) || (isset($_GET['caso']) && isset($_GET['categoria'])) || (isset($_GET['categoria']) && !in_array($_GET['categoria'], $categorias))) {
            echo '<div id="search-not-found">';
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
            echo '</div>';
        }
        else if (isset($_GET['caso']) && $_GET['caso'] === 'todos')
            echo self::mostrarEventos('general', false, '');
        else if (isset($_GET['caso']) && $_GET['caso'] === 'apuntados')
            echo self::mostrarEventos('apuntados', false, $_SESSION['nombre']);
        else if (isset($_GET['caso']) && $_GET['caso'] === 'creados')
            echo self::mostrarEventos('creados', false, $_GET['usuario']);
        else if (isset($_GET['categoria']))
            echo self::mostrarEventos('categoria', false, '');
        else {
            echo '<h1 id="titulo-evento-principal">Eventos</h1>';
            echo '<div class="proximosEventos">';
            echo self::mostrarEventos('general', true, '');
            echo '</div>';
            echo '<div class="eventosCreados">';
            echo self::mostrarEventos('creados', true, $_SESSION['nombre']);
            echo '</div>';
            echo '<div class="eventosApuntados">';
            echo self::mostrarEventos('apuntados', true, $_SESSION['nombre']);
            echo '</div>';
            echo '<div class="form-evento">';
            echo '    <h2>Crear evento</h2>';
            $formularioEvento = new FormularioEvento("form-evento", array( 'action' => 'eventos.php'));
            $formularioEvento->gestiona();
            echo '</div>';
        }
    }

    private static function mostrarEventosCaso($caso, $usuario, $resultado, $titulo, $ultimos){
        $html = '';
        $html .= $titulo;
        $html .= $caso === 'apuntados' && $ultimos && $resultado->num_rows > 3 ? '<a href="eventos.php?caso=apuntados"><button id="todosEventosApuntados">Ver todos los eventos a los que estás apuntado</button></a>' : '';
        $html .= $caso === 'general' && $ultimos && $resultado->num_rows > 3 ? '<a href="eventos.php?caso=todos"><button id="todosEventos">Ver todos los eventos</button></a>' : '';
        $creador = $usuario === $_SESSION['nombre'] ? 'ti' : $usuario;
        $html .= $caso === 'creados' && $ultimos && $resultado->num_rows > 3 ? '<a href="eventos.php?caso=creados&usuario=' . $usuario . '"><button id="todosEventosCreados">Ver todos los eventos creados por '. $creador . ' </button></a>' : '';
        if($resultado->num_rows !== 0) {
            $html .= '<div class="item-evento" id="header">
                        <div class="nombre-evento">
                            <label id="header">Nombre</label>
                        </div>
                        <div class="categoria-evento">
                          <label id="header">Categoría</label>
                        </div>
                        <div class="lugar-evento">
                            <label id="header">Lugar</label>
                        </div>
                        <div class="fecha-evento">
                            <label id="header">Fecha</label>
                        </div>
                        <div class="asistentes-evento">
                            <label id="header">Asistentes</label>
                        </div>
                      </div>';
            $i = 0;
            while (($fila = $resultado->fetch_assoc()) && ($i < 3 || !$ultimos)) {
                $evento = self::devuelveObjetoEvento((int)$fila['id']);
                $html .= '<div class="item-evento" id="' . $evento->id . '">
                            <div class="nombre-evento">
                                <label><a id="' . $evento->id . '" href="resultadoEvento.php?id=' . $evento->id . '" class="evento">' . $evento->nombreEvento . '</a></label>
                            </div>
                            <div class="categoria-evento">
                                <label><a class="categoria-evento" id="' . $evento->categoria . '" href="eventos.php?categoria=' . $evento->categoria . '">' . $evento->categoria . '</a></label>
                            </div>
                            <div class="lugar-evento">
                                <label><a class="lugar-evento" id="' . $evento->lugar . '" href="https://www.google.es/maps/search/' . $evento->lugar . '">' . $evento->lugar . '</a></label>
                            </div>
                            <div class="fecha-evento">
                                <label>' . $evento->fecha . '</label>
                            </div>
                            <div class="asistentes-evento">
                                <label>' . self::devuelveAsistentesEvento($evento->id) . '</label>
                            </div>
                          </div>';
                $i++;
            }
        }
        else{
            $idParrafo = $usuario === $_SESSION['nombre'] ? '' : ' id="separacionParrafo"' ;
            $html .= '<p' . $idParrafo . '>No hay eventos en la base de datos';
        }

        $resultado->free();

        return $html;   
    }

    public static function editarEvento(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !$evento = self::devuelveObjetoEvento((int)$_GET['id'])){
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
        }
        else {
            $id = (int)$_GET['id'];
            echo "<h1>" . $evento->nombreEvento . "</h1>";
            echo '<div id="divMensajes">';
            echo '</div>';
            echo "<div class='form-nombreEvento'>";
            echo "<h3>Cambiar nombre del evento</h3>";
            $formularioNombreEvento = new FormularioNombreEvento("form-nombreEvento", array( 'action' => 'editarEvento.php?id=' . $id));
            $formularioNombreEvento->gestiona();
            echo "</div>";
            echo "<div class='form-fechaEvento'>";
            echo "<h3>Cambiar fecha del evento</h3>";
            $formularioFechaEvento = new FormularioFechaEvento("form-FechaEvento", array( 'action' => 'editarEvento.php?id=' . $id));
            $formularioFechaEvento->gestiona();
            echo "</div>";
            echo "<div class='form-lugarEvento'>";
            echo "<h3>Cambiar lugar del evento</h3>";
            $formularioLugarEvento = new FormularioLugarEvento("form-lugarEvento", array( 'action' => 'editarEvento.php?id=' . $id));
            $formularioLugarEvento->gestiona();
            echo "</div>";
            echo "<div class='form-descripcionEvento'>";
            echo "<h3>Cambiar descripción del Evento</h3>";
            $formularioDescripcionEvento = new FormularioDescripcionEvento("form-DescripcionEvento", array( 'action' => 'editarEvento.php?id=' . $id));
            $formularioDescripcionEvento->gestiona();
            echo "</div>";
        }
    }

    public static function devuelveNumeroEventosCreados($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM eventos E WHERE E.creador = '%s'", $conn->real_escape_string($usuario));
        $resultado = $conn->query($query);
        return $resultado->num_rows;
    }
}
