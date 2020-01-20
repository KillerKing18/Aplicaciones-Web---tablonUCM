<?php
require_once __DIR__.'/Aplicacion.php';
require_once __DIR__.'/Archivo.php';
require_once __DIR__.'/Evento.php';
require_once __DIR__.'/Usuario.php';
require_once __DIR__.'/Valoracion.php';

class Novedad {

    private $fecha;

    private $usuarioEmisor;

    private $idReceptor;

    private $caso;

    private function __construct($fecha, $usuarioEmisor, $idReceptor, $caso){
        $this->fecha = $fecha;
        $this->usuarioEmisor = $usuarioEmisor;
        $this->idReceptor = $idReceptor;
        $this->caso = $caso;
    }

    private static function object_sorter($clave, $orden=null) {
        return function ($a, $b) use ($clave, $orden) {
              $result =  ($orden=="DESC") ? strnatcmp($b->$clave, $a->$clave) :  strnatcmp($a->$clave, $b->$clave);
              return $result;
        };
    }

    
    public static function devuelveArrayNovedades($tablas){
        $novedades = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        foreach ($tablas as $tabla){
            switch($tabla){
                case 'novedadeseventos':
                    $columna = 'idEvento';
                break;
                case 'novedadesarchivos':
                    $columna = 'idArchivo';
                break;
                case 'novedadesvaloracionesusuarios':
                    $columna = 'usuarioReceptor';
                break;
                case 'novedadesvaloracionesarchivos':
                    $columna = 'idArchivo';
                break;
            }
            $query = sprintf("SELECT * FROM " . $tabla);
            $rs = $conn->query($query);
            if (!$rs) {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
            while ($fila = $rs->fetch_assoc()) {
                $novedad = new Novedad($fila['fecha'], $fila['usuarioEmisor'], $fila[$columna], $tabla);
                $novedades[] = $novedad;
            }
        }
        $rs->free();
        return $novedades;
    }

    private static function obtenerDiferenciaTiempo($fechaNovedad) {
        $fechaActual = date("Y-m-d H:i:s");

        if((int)substr($fechaActual, 0, 4) === (int)substr($fechaNovedad, 0, 4)) //Mismo año
            if((int)substr($fechaActual, 5, 2) === (int)substr($fechaNovedad, 5, 2)) //Mismo mes
                if((int)substr($fechaActual, 8, 2) === (int)substr($fechaNovedad, 8, 2)) //Mismo día
                    if((int)substr($fechaActual, 11, 2) === (int)substr($fechaNovedad, 11, 2)) //Misma hora
                        if((int)substr($fechaActual, 14, 2) === (int)substr($fechaNovedad, 14, 2)) { //Mismo minuto
                            $numero = (int)substr($fechaActual, 17, 2) - (int)substr($fechaNovedad, 17, 2);
                            $unidad = $numero > 1 ? ' segundos' : ' segundo';
                        }
                        else {
                            $numero = (int)substr($fechaActual, 14, 2) - (int)substr($fechaNovedad, 14, 2);
                            $unidad = $numero > 1 ? ' minutos' : ' minuto';
                        }
                    else {
                        $numero = (int)substr($fechaActual, 11, 2) - (int)substr($fechaNovedad, 11, 2);
                        $unidad = $numero > 1 ? ' horas' : ' hora';
                    }
                else {
                    $numero = (int)substr($fechaActual, 8, 2) - (int)substr($fechaNovedad, 8, 2);
                    $unidad = $numero > 1 ? ' días' : ' día';
                }
            else {
                $numero = (int)substr($fechaActual, 5, 2) - (int)substr($fechaNovedad, 5, 2);
                $unidad = $numero > 1 ? ' meses' : ' mes';
            }
        else {
            $numero = (int)substr($fechaActual, 0, 4) - (int)substr($fechaNovedad, 0, 4);
            $unidad = $numero > 1 ? ' años' : ' año';
        }
        $texto = $numero . $unidad;
        return $texto;
    }

    public static function mostrarNovedades(){
        echo '<h2>Últimas novedades</h2>';

        $tablas = array('novedadeseventos', 'novedadesarchivos', 'novedadesvaloracionesusuarios', 'novedadesvaloracionesarchivos');

        $novedades = self::devuelveArrayNovedades($tablas);

        if (sizeof($novedades) > 0) {
            usort($novedades, self::object_sorter('fecha','DESC'));

            $i = 0;
    
            while (sizeof($novedades) > $i && $i < 7) {
                $novedad = $novedades[$i];
                $tiempo = self::obtenerDiferenciaTiempo($novedad->fecha);
                switch($novedad->caso){
                    case 'novedadeseventos':
                        $evento = Evento::devuelveObjetoEvento($novedad->idReceptor);
                        $texto = 'creado el evento <a href="resultadoEvento.php?id=' . $novedad->idReceptor . '">' . $evento->nombre() . '</a>';
                    break;
                    case 'novedadesarchivos':
                        $archivo = Archivo::devuelveObjetoArchivo($novedad->idReceptor);
                        $texto = 'creado el archivo <a href="resultadoArchivo.php?id=' . $novedad->idReceptor . '">' . $archivo->nombre() . '</a>';
                    break;
                    case 'novedadesvaloracionesusuarios':
                        $puntuacion = Valoracion::devuelveValoracionUsuarioUsuario($novedad->idReceptor, $novedad->usuarioEmisor);
                        $textoEstrellas = $puntuacion == 1 ? ' estrella' : ' estrellas' ;
                        $texto = 'valorado al usuario <a href="perfilAjeno.php?id=' . $novedad->idReceptor . '">' . $novedad->idReceptor . '</a> con una puntuación de ' . $puntuacion . $textoEstrellas;
                    break;
                    case 'novedadesvaloracionesarchivos':
                        $puntuacion = Valoracion::devuelveValoracionUsuarioArchivo($novedad->idReceptor, $novedad->usuarioEmisor);
                        $textoEstrellas = $puntuacion == 1 ? ' estrella' : ' estrellas' ;
                        $archivo = Archivo::devuelveObjetoArchivo($novedad->idReceptor);
                        $texto = 'valorado el archivo <a href="resultadoArchivo.php?id=' . $novedad->idReceptor . '">' . $archivo->nombre() . '</a> con una puntuación de ' . $puntuacion . $textoEstrellas;
                    break;
                }
                echo '<div class="novedad"><p class="novedad">El usuario <a href="perfilAjeno.php?id=' . $novedad->usuarioEmisor . '">' . $novedad->usuarioEmisor . '</a> ha ' . $texto . ' hace ' . $tiempo . '</p></div>';
                $i++;
            }
        }
        else{
            echo '<p>No hay novedades en la base de datos</p>';
        }
        
    }

    public static function crearNovedad($tabla, $columna, $idReceptor) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        switch ($columna) {
            case 'usuarioReceptor':
                $tercerParametro = "'%s'";
                $idReceptor = $conn->real_escape_string($idReceptor);
            break;
            case 'idArchivo':
            case 'idEvento':
                $tercerParametro = "'%d'";
            break;
        }
        if (($tabla === 'novedadesvaloracionesarchivos' || $tabla === 'novedadesvaloracionesusuarios') && self::existeNovedadValoracion($tabla, $columna, $idReceptor))
            $query = sprintf("UPDATE " . $tabla . " T SET fecha = '%s' WHERE T.usuarioEmisor = '%s' AND T." . $columna . " = " . $tercerParametro . ""
                , $conn->real_escape_string(date("Y-m-d H:i:s"))
                , $conn->real_escape_string($_SESSION['nombre'])
                , $idReceptor);
        else
            $query = sprintf("INSERT INTO " . $tabla . " (fecha, usuarioEmisor, " . $columna . ") VALUES ('%s', '%s', " . $tercerParametro . ")"
                , $conn->real_escape_string(date("Y-m-d H:i:s"))
                , $conn->real_escape_string($_SESSION['nombre'])
                , $idReceptor);
        if ( !$conn->query($query) ) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    private static function existeNovedadValoracion($tabla, $columna, $idReceptor) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        switch ($columna) {
            case 'usuarioReceptor':
                $tercerParametro = "'%s'";
                $idReceptor = $conn->real_escape_string($idReceptor);
            break;
            case 'idArchivo':
                $tercerParametro = "'%d'";
            break;
        }
        $query = sprintf("SELECT * FROM " . $tabla . " T WHERE T.usuarioEmisor = '%s' AND T." . $columna . " = " . $tercerParametro . ""
            , $conn->real_escape_string($_SESSION['nombre'])
            , $idReceptor);
        $resultado = $conn->query($query);
        return $resultado->num_rows > 0;
    }
}