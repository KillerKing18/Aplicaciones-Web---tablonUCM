<?php
require_once __DIR__.'/Aplicacion.php';

class Universidad
{

    public static function obtenerNombreCampoAsignatura($id, $tabla) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT nombre FROM " . $tabla . " T WHERE T.id = '%d'"
            , $id);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $fila = $rs->fetch_assoc();
        $devuelve = $fila['nombre'];
        $rs->free();
        return $devuelve;
    }

    private static function obtenerIdCampoAsignatura($id, $columna, $tabla){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT id". $columna . " FROM " . $tabla . " T WHERE T.id = '%d'"
            , $id);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $fila = $rs->fetch_assoc();
        $devuelve = $fila['id'. $columna];
        $rs->free();
        return $devuelve;
    }

    public static function obtenerCampoAsignatura($id, $campo) {
        $idCurso = self::obtenerIdCampoAsignatura($id, 'Curso', 'asignaturas');
        $idGrado = self::obtenerIdCampoAsignatura($idCurso, 'Grado', 'cursos');
        $idFacultad = self::obtenerIdCampoAsignatura($idGrado, 'Facultad', 'grados');
        switch($campo){
            case 'asignatura':
                return self::obtenerNombreCampoAsignatura($id, 'asignaturas');
            break;
            case 'curso':
                return self::obtenerNombreCampoAsignatura($idCurso, 'cursos');
            break;
            case 'grado':
                return self::obtenerNombreCampoAsignatura($idGrado, 'grados');
            break;
            case 'facultad':
                return self::obtenerNombreCampoAsignatura($idFacultad, 'facultades');
            break;
        }   
    }

    public static function borrarUniversidad() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM facultades");
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $query = sprintf("DELETE FROM grados");
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $query = sprintf("DELETE FROM cursos");
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $query = sprintf("DELETE FROM asignaturas");
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function borrarFacultad($id) {
        $ids = self::devuelveArrayAsignaturasFacultad($id);
        $archivos = Archivo::devuelveArrayArchivos($ids);
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM facultades WHERE id = '%d'"
            , $id);
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        foreach ($archivos as $archivo)
            unlink('data/archivos/' . $archivo->id() . '.' . $archivo->formato());
    }

    public static function borrarGrado($id) {
        $archivos = Archivo::devuelveArrayArchivos(self::devuelveArrayAsignaturasGrado($id));
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM grados WHERE id = '%d'"
            , $id);
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        foreach ($archivos as $archivo)
            unlink('data/archivos/' . $archivo->id() . '.' . $archivo->formato());
    }

    public static function borrarCurso($id) {
        $archivos = Archivo::devuelveArrayArchivos(self::devuelveArrayAsignaturasCurso($id));
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM cursos WHERE id = '%d'"
            , $id);
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        foreach ($archivos as $archivo)
            unlink('data/archivos/' . $archivo->id() . '.' . $archivo->formato());
    }

    public static function borrarAsignatura($id) {
        $ids = array();
        $ids[] = $id;
        $archivos = Archivo::devuelveArrayArchivos($ids);
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM asignaturas WHERE id = '%d'"
            , $id);
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        foreach ($archivos as $archivo)
            unlink('data/archivos/' . $archivo->id() . '.' . $archivo->formato());
    }

    public static function devuelveArrayAsignaturasCurso($idCurso){
        $ids = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM asignaturas A WHERE A.idCurso = '%d'", $idCurso);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        while ($fila = $rs->fetch_assoc())
            $ids[] = $fila['id'];
        $rs->free();
        return $ids;
    }

    public static function devuelveArrayCursosGrado($idGrado){
        $ids = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM cursos C WHERE C.idGrado = '%d'", $idGrado);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        while ($fila = $rs->fetch_assoc())
            $ids[] = $fila['id'];
        if ($rs->num_rows > 0)
            $rs->free();
        return $ids;
    }

    public static function devuelveArrayAsignaturasGrado($idGrado){
        $ids = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idsCurso = self::devuelveArrayCursosGrado($idGrado);
        foreach ($idsCurso as $idCurso){
            $query = sprintf("SELECT * FROM asignaturas A WHERE A.idCurso = '%d'", $idCurso);
            $rs = $conn->query($query);
            if (!$rs) {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
            while ($fila = $rs->fetch_assoc())
                $ids[] = $fila['id'];
        }
        if (sizeof($idsCurso) > 0)
            $rs->free();
        return $ids;
    }

    public static function devuelveArrayGradosFacultad($idFacultad){
        $ids = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM grados G WHERE G.idFacultad = '%d'", $idFacultad);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        while ($fila = $rs->fetch_assoc())
            $ids[] = $fila['id'];
        if ($rs->num_rows > 0)
            $rs->free();
        return $ids;
    }

    public static function devuelveArrayAsignaturasFacultad($idFacultad){
        $ids = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idsGrado = self::devuelveArrayGradosFacultad($idFacultad);
        foreach ($idsGrado as $idGrado){
            $idsCurso = self::devuelveArrayCursosGrado($idGrado);
            foreach ($idsCurso as $idCurso){
                $query = sprintf("SELECT * FROM asignaturas A WHERE A.idCurso = '%d'", $idCurso);
                $rs = $conn->query($query);
                if (!$rs) {
                    echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                    exit();
                }
                while ($fila = $rs->fetch_assoc())
                    $ids[] = $fila['id'];
            }
        }
        if (sizeof($idsGrado) > 0)
            $rs->free();
        return $ids;
    }

    public static function creaObjetoUniversidad($nombre, $idSuperior, $tabla, $columna){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO " . $tabla . "(nombre, id" . $columna . ") VALUES ('%s', '%d')"
            , $conn->real_escape_string($nombre)
            , $idSuperior);
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function existeObjetoUniversidad($nombre, $idSuperior, $tabla, $columna){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM " . $tabla . " WHERE nombre = '%s' AND id" . $columna . " = '%d'"
            , $conn->real_escape_string($nombre)
            , $idSuperior);
        $resultado = $conn->query($query);
        return $resultado->num_rows > 0;
    }

    private static function existenArchivosAsignatura($asignatura) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM archivos WHERE asignatura = '%d' "
            , $asignatura);
        $resultado = $conn->query($query);
        return $resultado->num_rows > 0;
    }

    public static function existeFacultad($nombre) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM facultades WHERE nombre = '%s'", $conn->real_escape_string($nombre));
        $resultado = $conn->query($query);
        return $resultado->num_rows > 0;
    }

    public static function existeFacultadID($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM facultades F WHERE F.id = '%d'", $id);
        $rs = $conn->query($query);
        $existe = false;
        if ($rs) {
            if ( $rs->num_rows == 1)
                $existe = true;
            $rs->free();
        }
        else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $existe;
    }

    public static function existeGradoID($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM grados G WHERE G.id = '%d'", $id);
        $rs = $conn->query($query);
        $existe = false;
        if ($rs) {
            if ( $rs->num_rows == 1)
                $existe = true;
            $rs->free();
        }
        else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $existe;
    }

    public static function existeCursoID($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM cursos C WHERE C.id = '%d'", $id);
        $rs = $conn->query($query);
        $existe = false;
        if ($rs) {
            if ( $rs->num_rows == 1)
                $existe = true;
            $rs->free();
        }
        else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $existe;
    }

    public static function creaFacultad($nombre) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("INSERT INTO facultades(nombre) VALUES ('%s')"
            , $conn->real_escape_string($nombre));
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function creaAsignatura($nombre, $curso) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("INSERT INTO asignaturas(nombre, idCurso, zip) VALUES ('%s', '%d', '%d')"
            , $conn->real_escape_string($nombre)
            , $curso
            , 1);
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    private static function devuelveFacultades() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT nombre, id FROM facultades");
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    private static function devuelveObjetos($id, $columna, $tabla)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT DISTINCT nombre, id FROM " . $tabla . " T WHERE T.id" . $columna . " = '%d'", $id);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function creaOpcionesGenerico($id, $columna, $tabla, $elija, $noHay, $facultad) {

        $resultado = $facultad ? Universidad::devuelveFacultades() : Universidad::devuelveObjetos($id, $columna, $tabla);
        $options = '<option value="" disabled selected>Elija ' . $elija . '</option>';
        $hayOpciones = false;
		while ($fila = $resultado->fetch_assoc()) {
            $hayOpciones = true;
			$options .= '<option value="' . $fila["id"] . '">' . $fila["nombre"] . '</option>';
		}
        $resultado->free();
        if(!$hayOpciones)
            $options .= '<option value="-1" disabled>No hay ' . $noHay . ' en la base de datos</option>';
        return $options;
    }

    public static function creaOpcionesCategorias(){
		$options = '<option value="" disabled selected>Elija una categoría</option>';
        $options .= '<option value="Teoría">Teoría</option>';
        $options .= '<option value="Ejercicios">Ejercicios</option>';
        $options .= '<option value="Exámenes">Exámenes</option>';
        $options .= '<option value="Prácticas">Prácticas</option>';
        return $options;
    }

    public static function zipAsignaturaActualizado($asignatura){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT zip FROM asignaturas A WHERE A.id = '%d'"
            , $asignatura);
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $subject = $rs->fetch_assoc();
		return $subject['zip'];
    }

    public static function cambiarZIPAsignatura($asignatura, $zip){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE asignaturas A SET zip = '%d' WHERE A.id = '%d'"
            , $zip
            , $asignatura);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la asignatura";
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function existeAsignaturaID($asignatura) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM asignaturas A WHERE A.id = '%d'", $asignatura);
        $rs = $conn->query($query);
        $existe = false;
        if ($rs) {
            if ( $rs->num_rows == 1)
                $existe = true;
            $rs->free();
        }
        else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $existe;
    }

    public static function marcarAsignatura($idAsignatura, $idUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO asignaturasmarcadas(idAsignatura, idUsuario) VALUES('%d', '%s')"
            , $idAsignatura
            , $conn->real_escape_string($idUsuario));
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function desmarcarAsignatura($idAsignatura, $idUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM asignaturasmarcadas WHERE idAsignatura = '%d' AND idUsuario = '%s'"
            , $idAsignatura
            , $conn->real_escape_string($idUsuario));
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function asignaturaMarcada($idAsignatura, $idUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM asignaturasmarcadas WHERE idAsignatura = '%d' AND idUsuario = '%s'"
            , $idAsignatura
            , $conn->real_escape_string($idUsuario));
        $resultado = $conn->query($query);
        return $resultado->num_rows === 1;
    }

    private static function devuelveAsignaturasMarcadasUsuario($idUsuario){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM asignaturasmarcadas A WHERE A.idUsuario = '%s'"
            , $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $rs;
    }

    public static function mostrarAsignaturasMarcadas($idUsuario) {
        $html = '';
        $resultado = self::devuelveAsignaturasMarcadasUsuario($idUsuario);
        if($resultado->num_rows !== 0) {
            $html .= '<div class="item-asignatura" id="header">
                        <div class="nombre-asignatura">
                            <label id="header">Nombre</label>
                        </div>
                        <div class="curso-asignatura">
                            <label id="header">Curso</label>
                        </div>
                        <div class="grado-asignatura">
                            <label id="header">Grado</label>
                        </div>
                        <div class="facultad-asignatura">
                            <label id="header">Facultad</label>
                        </div>
                      </div>';
            while ($fila = $resultado->fetch_assoc())
                $html .= '<div class="item-asignatura" id="' . $fila['idAsignatura'] . '">
                            <div class="nombre-asignatura">
                                <label><a id="' . $fila['idAsignatura'] . '" href="resultadoBuscador.php?asignatura=' . $fila['idAsignatura'] . '" class="asignatura">' . self::obtenerCampoAsignatura($fila['idAsignatura'], 'asignatura') . '</a></label>
                            </div>
                            <div class="curso-asignatura">
                                <label> ' . self::obtenerCampoAsignatura($fila['idAsignatura'], 'curso') . '</label>
                            </div>
                            <div class="grado-asignatura">
                                <label> ' . self::obtenerCampoAsignatura($fila['idAsignatura'], 'grado') . '</label>
                            </div>
                            <div class="facultad-asignatura">
                                <label> ' . self::obtenerCampoAsignatura($fila['idAsignatura'], 'facultad') . '</label>
                            </div>
                          </div>';
        }
        else
            $html .= '<p id="asignaturaMarcada">Aún no has marcado ninguna asignatura';
        $resultado->free();

        return $html;
    }
}