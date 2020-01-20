<?php
require_once __DIR__.'/Aplicacion.php';
require_once __DIR__.'/Archivo.php';

class Valoracion {
    
    public static function insertaValoracionArchivo($puntuacion, $id){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO valoracionesarchivos (idArchivo, usuarioEmisor, puntuacion) VALUES ('%d', '%s', '%d')"
            , $id
            , $conn->real_escape_string($_SESSION['nombre'])
            , $puntuacion);
        return $conn->query($query);
    }

    public static function insertaValoracionUsuario($puntuacion, $id){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO valoracionesusuarios (usuarioReceptor, usuarioEmisor, puntuacion) VALUES ('%s', '%s', '%d')"
            , $conn->real_escape_string($id)
            , $conn->real_escape_string($_SESSION['nombre'])
            , $puntuacion);
        return $conn->query($query);
    }
    
    public static function cambiaPuntuacionUsuario($nuevaPuntuacion, $id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE valoracionesusuarios V SET puntuacion ='%d' WHERE V.usuarioReceptor='%s' AND V.usuarioEmisor='%s'"
            , $nuevaPuntuacion
            , $conn->real_escape_string($id)
            , $conn->real_escape_string($_SESSION['nombre']));
        return $conn->query($query);
    }

    public static function cambiaPuntuacionArchivo($nuevaPuntuacion, $id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("UPDATE valoracionesarchivos V SET puntuacion ='%d' WHERE V.idArchivo='%s' AND V.usuarioEmisor='%s'"
            , $nuevaPuntuacion
            , $id
            , $conn->real_escape_string($_SESSION['nombre']));
        if ( !$conn->query($query) ) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function borrarValoracionesUsuario($nombreUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM valoracionesusuarios WHERE usuarioEmisor = '%s'", $conn->real_escape_string($nombreUsuario));
        if ( !$conn->query($query) ) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function devuelveMediaValoracionesArchivo($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT ROUND(AVG(puntuacion), 2) AS avg FROM valoracionesarchivos V WHERE V.idArchivo ='%d'", $id);
        $result = $conn->query($query);
        $fila = $result->fetch_assoc();
        return $fila['avg'] == null ? 0 : $fila['avg'];
    }

    public static function devuelveValoracionUsuarioArchivo($id, $usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT puntuacion FROM valoracionesarchivos V WHERE V.idArchivo = '%d' AND V.usuarioEmisor = '%s'"
            , $id
            , $conn->real_escape_string($usuario));
        $result = $conn->query($query);
        $fila = $result->fetch_assoc();
        return $fila['puntuacion'];
    }

    public static function devuelveValoracionUsuarioUsuario($id, $usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT puntuacion FROM valoracionesusuarios V WHERE V.usuarioReceptor = '%s' AND V.usuarioEmisor = '%s'"
            , $conn->real_escape_string($id)
            , $conn->real_escape_string($usuario));
        $result = $conn->query($query);
        $fila = $result->fetch_assoc();
        return $fila['puntuacion'];
    }

    public static function devuelveMediaValoracionesUsuario($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT ROUND(AVG(puntuacion), 2) AS avg FROM valoracionesusuarios V WHERE V.usuarioReceptor ='%s'", $conn->real_escape_string($id));
        $result = $conn->query($query);
        $fila = $result->fetch_assoc();
        return $fila['avg'] == null ? 0 : $fila['avg'];
    }
}
