<?php
require_once __DIR__.'/Aplicacion.php';
require_once __DIR__.'/Archivo.php';
require_once __DIR__.'/Evento.php';

class Reporte {
    
    public static function creaReporte($fecha, $asunto, $texto, $usuarioEmisor, $idReceptor, $caso){
        $reporte = new Reporte($fecha, $asunto, $texto, $usuarioEmisor, $idReceptor);
        return self::insertaReporte($reporte, $caso);
    }
    
    private static function insertaReporte($reporte, $caso){
        $tabla = "";
        $objetoReceptor = "";
        $formatoIdReceptor = "";
        switch ($caso){
            case 'usuario':
                $tabla = "reportesusuarios";
                $objetoReceptor = "usuarioReceptor";
                $formatoIdReceptor = "'%s'";
                break;
            case 'evento':
                $tabla = "reporteseventos";
                $objetoReceptor = "evento";
                $formatoIdReceptor = "'%d'";
                break;
            case'archivo':
                $tabla = "reportesarchivos";
                $objetoReceptor = "archivo";
                $formatoIdReceptor = "'%d'";
                break;
        }
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $tercerParametro = $formatoIdReceptor === "'%d'" ? $reporte->idReceptor : $conn->real_escape_string($reporte->idReceptor) ;
        $query = sprintf("INSERT INTO " . $tabla. "(fecha, asunto, texto, usuarioEmisor, " . $objetoReceptor . ") VALUES ('%s', '%s', '%s', '%s', " . $formatoIdReceptor . ")"
            , $conn->real_escape_string($reporte->fecha)
            , $conn->real_escape_string($reporte->asunto)
            , $conn->real_escape_string($reporte->texto)
            , $conn->real_escape_string($reporte->usuarioEmisor)
			, $tercerParametro);
        if ( $conn->query($query) ) {
            $reporte->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $reporte;
    }
    
    private $id;

    private $fecha;

    private $asunto;

    private $texto;

    private $usuarioEmisor;

    private $idReceptor;

    private function __construct($fecha, $asunto, $texto, $usuarioEmisor, $idReceptor){
        $this->fecha = $fecha;
        $this->asunto = $asunto;
        $this->texto = $texto;
        $this->usuarioEmisor = $usuarioEmisor;
        $this->idReceptor = $idReceptor;
    }

    public function id(){
        return $this->id;
    }

    public function fecha(){
        return $this->fecha;
    }

    public function asunto(){
        return $this->asunto;
    }

    public function texto(){
        return $this->texto;
    }

    public function usuarioEmisor(){
        return $this->usuarioEmisor;
    }

    public function idReceptor(){
        return $this->idReceptor;
    }

    private static function devuelveUltimosReportes($caso){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM reportes" . $caso . " R ORDER BY fecha DESC LIMIT 5");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveTodosReportes($caso){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM reportes" . $caso . " R");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function existenReportes($caso) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM reportes" . $caso);
        $resultado = $conn->query($query);
        return $resultado->num_rows > 0;
    }

    public static function mostrarUltimosReportes($ultimos, $caso){
        switch ($caso){
            case 'usuarios':
                $divReferenciadoHeader =    '<div class="receptor-reporte">
                                                <label id="header">Receptor</label>
                                            </div>';
                break;
            case 'archivos':
                $divReferenciadoHeader =    '<div class="archivo-reporte">
                                                <label id="header">Archivo</label>
                                            </div>';
                break;
            case 'eventos':
                $divReferenciadoHeader = '  <div class="evento-reporte">
                                                <label id="header">Evento</label>
                                            </div>';
                break;
        }
        $html = '';
        $html .= $ultimos ? '<h2>Últimos reportes sobre ' . $caso . '</h2>' : '<h1>Reportes sobre ' . $caso . '</h1>';
        $html .= $ultimos && self::existenReportes($caso) ? '<a href="reportesAdministrador.php?caso=' . $caso . '"><button id="todosReportes">Ver todos los reportes sobre ' . $caso . '</button></a>' : '';
        $resultado = $ultimos ? self::devuelveUltimosReportes($caso) : self::devuelveTodosReportes($caso);
        if($resultado->num_rows !== 0) {
            $html .= '<div class="item-reporte" id="header">
                        <div class="asunto-reporte">
                            <label id="header">Asunto</label>
                        </div>
                        <div class="emisor-reporte">
                            <label id="header">Emisor</label>
                        </div>'
                        . $divReferenciadoHeader .
                        '<div class="fecha-reporte">
                            <label id="header">Fecha</label>
                        </div>
                      </div>';
            while ($fila = $resultado->fetch_assoc()) {
                switch ($caso){
                    case 'usuarios':
                        $divReferenciadoContenido = '<div class="receptor-reporte">
                                                        <label><a id="' . $fila['usuarioReceptor'] . '" href="perfilAjeno.php?id=' . $fila['usuarioReceptor'] . '" class="receptor">' . $fila['usuarioReceptor'] . '</a></label>
                                                    </div>';
                        break;
                    case 'archivos':
                        $archivo = Archivo::devuelveObjetoArchivo($fila['archivo']);
                        $divReferenciadoContenido =    '<div class="archivo-reporte">
                                                            <label><a id="' . $fila['archivo'] . '" href="resultadoArchivo.php?id=' . $fila['archivo'] . '" class="file">' . $archivo->nombre() . '</a></label>
                                                        </div>';
                        break;
                    case 'eventos':
                        $evento = Evento::devuelveObjetoEvento($fila['evento']);
                        $divReferenciadoContenido =    '<div class="evento-reporte">
                                                            <label><a id="' . $fila['evento'] . '" href="resultadoEvento.php?id=' . $fila['evento'] . '" class="evento">' . $evento->nombre() . '</a></label>
                                                        </div>';
                        break;
                }
                $html .= '<div class="item-reporte" id="' . $fila['id'] . '">
                            <div class="asunto-reporte">
                                <label><a id="' . $fila['id'] . '" href="reporte.php?caso=' . $caso . '&id=' . $fila['id'] . '" class="reporte">' . $fila['asunto'] . '</a></label>
                            </div>
                            <div class="emisor-reporte">
                                <label><a id="' . $fila['usuarioEmisor'] . '" href="perfilAjeno.php?id=' . $fila['usuarioEmisor'] . '" class="emisor">' . $fila['usuarioEmisor'] . '</a></label>
                            </div>'
                            . $divReferenciadoContenido .
                            '<div class="fecha-reporte">
                                <label> ' . substr($fila['fecha'], 8, 2) . '/' . substr($fila['fecha'], 5, 2) . '/' . substr($fila['fecha'], 0, 4) . '</label>
                            </div>
                          </div>';
            }
        }
        else{
            $idParrafo = $caso === 'usuarios' ? ' id="ultimoParrafo"' : "";
            $html .= '<p' . $idParrafo . '>No hay reportes en la base de datos';
        }
        $resultado->free();

        return $html;   
    }

    private static function devuelveObjetoReporte($id, $caso){
        switch ($caso){
            case 'usuarios':
                $idReceptor = "usuarioReceptor";
                break;
            case 'archivos':
                $idReceptor = "archivo";
                break;
            case 'eventos':
                $idReceptor = "evento";
                break;
        }
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM reportes" . $caso . " R WHERE R.id = '%d'", $id);
        $resultado = $conn->query($query);
        if (!$resultado) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $existe = false;
        if ($resultado->num_rows == 1) {
            $info = $resultado->fetch_assoc();
            $reporte = new Reporte($info["fecha"], $info["asunto"], $info["texto"], $info["usuarioEmisor"], $info[$idReceptor]);
            $existe = $reporte;
            $reporte->id = $info["id"];
        }
        $resultado->free();
        return $existe;
    }

    public static function reportesAdministrador() {
        $casos = array('usuarios', 'eventos', 'archivos');
        if (!isset($_GET['caso']) || !in_array($_GET['caso'], $casos)) {
            echo '<div id="report-not-found">';
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
            echo '</div>';
        }
        else {
            if ($_GET['caso'] === 'usuarios')
                echo Reporte::mostrarUltimosReportes(false, 'usuarios');
            else if ($_GET['caso'] === 'archivos')
                echo Reporte::mostrarUltimosReportes(false, 'archivos');
            else if ($_GET['caso'] === 'eventos')
                echo Reporte::mostrarUltimosReportes(false, 'eventos');
        }
    }

    public static function mostrarReporte($caso){
        $distinto = $caso !== 'usuarios' && $caso !== 'archivos' && $caso !== 'eventos';
        if ($distinto || (!isset($_GET['id'])) || (!is_numeric($_GET['id'])) || (!$reporte = self::devuelveObjetoReporte((int)$_GET['id'], $caso))) {
            echo '<div id="report-not-found">';
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
            echo '</div>';
        }
        else {
            switch ($caso){
                case 'usuarios':
                    $labelObjetoReferenciado = 'Usuario referenciado';
                    $linkObjetoReferenciado = '<a id="' . $reporte->idReceptor() . '" href="perfilAjeno.php?id=' . $reporte->idReceptor() . '" class="receptor">' . $reporte->idReceptor() . '</a>';
                    break;
                case 'archivos':
                    $archivo = Archivo::devuelveObjetoArchivo($reporte->idReceptor());
                    $labelObjetoReferenciado = 'Archivo referenciado';
                    $linkObjetoReferenciado = '<a id="' . $reporte->idReceptor() . '" href="resultadoArchivo.php?id=' . $reporte->idReceptor() . '" class="file">' . $archivo->nombre() . '</a>';
                    break;
                case 'eventos':
                    $evento = Evento::devuelveObjetoEvento($reporte->idReceptor());
                    $labelObjetoReferenciado = 'Evento referenciado';
                    $linkObjetoReferenciado = '<a id="' . $reporte->idReceptor() . '" href="resultadoEvento.php?id=' . $reporte->idReceptor() . '" class="file">' . $evento->nombre() . '</a>';
                    break;
            }
            echo '<div id="reporte-display">
                    <h2>' . $reporte->asunto() . '</h2>
                    <div id="texto-reporte">
                        <p>' . $reporte->texto() . '</p>
                    </div>
                    <div class="info-reporte" id="header">
                        <div class="emisor-reporte-display">
                            <label id="header">Usuario emisor</label>
                        </div>
                        <div class="referenciado-reporte-display">
                                <label id="header">' . $labelObjetoReferenciado . '</label>
                        </div>
                        <div class="fecha-reporte-display">
                            <label id="header">Fecha</label>
                        </div>
                    </div>';
            echo    '<div class="info-reporte" id="' . (int)$_GET['id'] . '">
                        <div class="emisor-reporte-display">
                            <label><a id="' . $reporte->usuarioEmisor() . '" href="perfilAjeno.php?id=' . $reporte->usuarioEmisor() . '" class="emisor">' . $reporte->usuarioEmisor() . '</a></label>
                        </div>
                        <div class="referenciado-reporte-display">
                            <label>' . $linkObjetoReferenciado . '</label>
                        </div>
                        <div class="fecha-reporte-display">
                            <label>' . substr($reporte->fecha(), 8, 2) . '/' . substr($reporte->fecha(), 5, 2) . '/' . substr($reporte->fecha(), 0, 4) . '</label>
                        </div>
                    </div>';
            echo    '<div class="form-borrarReporte">';
            echo        '<h3>Borrar reporte</h3>';
            $formularioBorrarReporte = new FormularioBorrarReporte("form-borrarReporte", array( 'action' => 'reporte.php?caso=' . $caso . '&id=' . (int)$_GET['id']));
            $formularioBorrarReporte->gestiona();
            echo    '</div>';
            echo '</div>';
        }
    }

    public function borrarReporte($id, $caso) {
        $reporte = self::devuelveObjetoReporte($id, $caso);
        if($reporte) {
            $app = Aplicacion::getSingleton();
            $conn = $app->conexionBd();
            $query = sprintf("DELETE FROM reportes" . $caso . " WHERE id = '%d'", $reporte->id());
            if ( !$conn->query($query) ) {
                echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
            return true;
        }
        else
            return false;
    }
}
