<?php
require_once __DIR__.'/Aplicacion.php';
require_once __DIR__.'/Archivo.php';
require_once __DIR__.'/Evento.php';

class Usuario
{

    public static function login($nombreUsuario, $password) {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($nombreUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nombreUsuario = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $result = new Usuario($fila['nombreUsuario'], $fila['email'], $fila['password'], $fila['rol'], $fila['extensionImagen']);
            }
            $rs->free();
        }
        else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($nombreUsuario, $email, $password, $rol) {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user)
            return false;
        $user = new Usuario($nombreUsuario, $email, self::hashPassword($password), $rol, '');
        return self::inserta($user);
    }
    
    private static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    private static function inserta($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO usuarios(nombreUsuario, email, password, rol, extensionImagen) VALUES('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $conn->real_escape_string($usuario->extensionImagen));
        if (!$conn->query($query)) {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
    
    private static function actualiza($usuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("UPDATE usuarios U SET nombreUsuario = '%s', email ='%s', password ='%s', rol='%s', extensionImagen='%s' WHERE U.nombreUsuario='%s'"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $conn->real_escape_string($usuario->extensionImagen)
            , $conn->real_escape_string($usuario->nombreUsuario));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->nombreUsuario;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }        
        return $usuario;
    }

    private $nombreUsuario;

    private $email;

    private $password;

    private $rol;

    private $extensionImagen;

    private function __construct($nombreUsuario, $email, $password, $rol, $extensionImagen) {
        $this->nombreUsuario = $nombreUsuario;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        $this->extensionImagen = $extensionImagen;
    }

    public function rol() {
        return $this->rol;
    }

    public function email() {
        return $this->email;
    }

    public function nombreUsuario() {
        return $this->nombreUsuario;
    }

    public function extensionImagen() {
        return $this->extensionImagen;
    }

    public function compruebaPassword($password) {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevaPassword) {
        $this->password = self::hashPassword($nuevaPassword);
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE usuarios U SET password ='%s' WHERE U.nombreUsuario='%s'"
            , $conn->real_escape_string($this->password)
            , $conn->real_escape_string($this->nombreUsuario));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la contraseña: " . $this->nombreUsuario;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public function editarEmail($nuevoEmail) {
        $this->email = $nuevoEmail;
        $this->cambiaEmail();
    }

    private function cambiaEmail() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE usuarios U SET email ='%s' WHERE U.nombreUsuario='%s'"
            , $conn->real_escape_string($this->email)
            , $conn->real_escape_string($this->nombreUsuario));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el email: " . $this->nombreUsuario;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public function editarNombreUsuario($nuevoNombreUsuario) {
        if(self::buscaUsuario($nuevoNombreUsuario))
            return false;
        else {
            $this->cambiaNombreUsuario($nuevoNombreUsuario);
            $this->nombreUsuario = $nuevoNombreUsuario;
            return true;
        }
    }

    private function cambiaNombreUsuario($nuevoNombreUsuario) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE usuarios U SET nombreUsuario ='%s' WHERE U.nombreUsuario='%s'"
            , $conn->real_escape_string($nuevoNombreUsuario)
            , $conn->real_escape_string($this->nombreUsuario));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el nombre de usuario: " . $this->nombreUsuario;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public function editarImagen($extensionImagen) {
        $cambio = false;
        if($this->extensionImagen !== $extensionImagen){
            $this->extensionImagen = $extensionImagen;
            $cambio = true;
        }
        if ($cambio)
            $this->cambiaImagen();
    }

    public function cambiaImagen() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query =sprintf("UPDATE usuarios U SET extensionImagen='%s' WHERE U.nombreUsuario='%s'"
            , $conn->real_escape_string($this->extensionImagen)
            , $conn->real_escape_string($this->nombreUsuario));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows !== 1) {
                echo "No se ha podido actualizar la imagen: " . $this->nombreUsuario;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        $affected_rows = $conn->affected_rows;
    }

    public function mostrarPerfil() {
        $html = '<div id="datos">';
        $html .= '<div id="datosIzquierda">';
        $html .= '<h4>Nombre de usuario</h4>';
        $html .= $this->nombreUsuario;
        $html .= '<br>';
        $html .= '<h4>E-mail</h4>';
        $html .= $this->email;
        $html .= '<br>';
        $html .= '<h4>Valoración</h4>';
        $html .=    '<div class="rate" id="rateUsuario">
                            <span id="average">' . Valoracion::devuelveMediaValoracionesUsuario($this->nombreUsuario) . '</span>
                        </div>';
        $html .= '</div>';
        $html .= '<div id="datosDerecha">';
        $html .= '<h4>Archivos subidos</h4>';
        $html .= Archivo::devuelveNumeroArchivosSubidos($_SESSION['nombre']);
        $html .= '<br>';
        $html .= '<h4>Eventos creados</h4>';
        $html .= Evento::devuelveNumeroEventosCreados($_SESSION['nombre']);
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div id="imagenPerfil">';
        $path = $this->extensionImagen !== '' ? 'data/usuarios/' . $this->nombreUsuario . '.' . $this->extensionImagen : 'img/profile/default.png';
        $html .= '<img alt="Foto de perfil" src="' . $path . '"></img>';
        $html .= '<button id="subirImagen">Cambiar imagen</button>';
        $html .= '</div>';
        return $html;
    }

    public static function mostrarPerfilAjeno(){
        $usuario = false;
        if (isset($_REQUEST['id']) && $_REQUEST['id'] !== "") {
            $id = $_REQUEST['id'];
            $usuario = self::buscaUsuario($id);
        }

        if($usuario){
            if (isset($_REQUEST['caso']) && $_REQUEST['caso'] === "archivos")
                echo Archivo::generaArchivosUsuario(false, $id);
            else {
                echo '<h1 class="titulo" id="' . $id . '">Perfil de ' . $id . '</h1>';
                echo '<div class="info">';
                echo '<div id="datos">';
                echo '<div id="datosIzquierda">';
                echo '<h4>Nombre de usuario</h4>';
                echo $usuario->nombreUsuario;
                echo '<br>';
                echo '<h4>E-mail</h4>';
                echo $usuario->email;
                echo '<br>';
                echo '<h4>Valoración</h4>';
                echo    '<div class="rate" id="rateUsuario">';
                if ($id !== $_SESSION['nombre']) {
                    echo    '<label for="star1" id="labelstar1"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                            <input class="estrella" type="radio" name="star1" id="star1"/>
                            <label for="star2" id="labelstar2"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                            <input class="estrella" type="radio" name="star2" id="star2"/>
                            <label for="star3" id="labelstar3"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                            <input class="estrella" type="radio" name="star3" id="star3"/>
                            <label for="star4" id="labelstar4"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                            <input class="estrella" type="radio" name="star4" id="star4"/>
                            <label for="star5" id="labelstar5"><img class="star-img" alt="Unmarked star" src="img/validacion/unmarkedstar.png"/></label>
                            <input class="estrella" type="radio" name="star5" id="star5"/>
                            <span id="average">(' . Valoracion::devuelveMediaValoracionesUsuario($id) . ')</span>';
                }
                else 
                    echo   '<span id="average">' . Valoracion::devuelveMediaValoracionesUsuario($id) . '</span>';
                echo '</div>';  
                echo '</div>';  
                echo '<div id="datosDerecha">';
                echo '<h4>Archivos subidos</h4>';
                echo Archivo::devuelveNumeroArchivosSubidos($usuario->nombreUsuario());
                echo '<br>';
                echo '<h4>Eventos creados</h4>';
                echo Evento::devuelveNumeroEventosCreados($usuario->nombreUsuario);
                echo '</div>';
                echo '</div>';
                echo '<div id="imagenPerfilAjeno">';
                $path = $usuario->extensionImagen !== '' ? 'data/usuarios/' . $usuario->nombreUsuario . '.' . $usuario->extensionImagen : 'img/profile/default.png';
                echo '<img alt="Foto de perfil" src="' . $path . '"></img>';
                echo '</div>';
                echo '</div>';
                echo Archivo::generaArchivosUsuario(true, $id);
                echo Evento::mostrarEventos('creados', true, $id);
                if ($id !== $_SESSION['nombre']) {
                    echo '<div id="reporte-user">';
                    echo '<h2>Generar reporte sobre el usuario:</h2>';
                    $formularioReporte = new FormularioReporte("form-reporte-usuario", array( 'action' => 'perfilAjeno.php?id=' . $id));
                    $formularioReporte->gestiona();
                    echo '</div>';
                }
                if($_SESSION['esAdmin']) {
                    echo '<div class="form-borrarCuenta">';
                    echo '<h2>Borrar cuenta</h2>';
                    echo '<p id="borradoCuenta">Atención: Todos los archivos asociados a esta cuenta serán borrados automáticamente.</p>';
                    $formularioBorrarCuenta = new FormularioBorrarCuenta("form-borrarCuenta", array( 'action' => 'perfilAjeno.php?id=' . $id));
                    $formularioBorrarCuenta->gestiona();
                    echo '</div>';
                }
            }
        }
        else {
            echo '<h1>¡Oops!</h1>';
            echo '<p>¡Vaya! Parece que algo salió mal...</p>';
        }
    }

    public function borrarUsuario(){
        $archivosUsuario = Archivo::devuelveArrayArchivosUsuario($this->nombreUsuario);
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM usuarios WHERE nombreUsuario = '%s'", $conn->real_escape_string($this->nombreUsuario));
        if (!$conn->query($query)) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        foreach ($archivosUsuario as $archivo)
            unlink('data/archivos/' . $archivo);
        if($this->extensionImagen !== '')
            unlink('data/usuarios/' . $this->nombreUsuario . '.' . $this->extensionImagen);
    }

    public static function borrarUsuarios() {
        $usuarios = self::devuelveArrayUsuarios();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM usuarios WHERE nombreUsuario != '%s'", $conn->real_escape_string($_SESSION['nombre']));
        if (!$conn->query($query)) {
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        Usuario::delete_directory('data/archivos');
        foreach ($usuarios as $usuario){
            if($usuario->extensionImagen !== '')
                unlink('data/usuarios/' . $usuario->nombreUsuario . '.' . $usuario->extensionImagen);
        }
    }

    public static function devuelveArrayUsuarios(){
        $usuarios = array();
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE nombreUsuario != '%s'", $conn->real_escape_string($_SESSION['nombre']));
        $rs = $conn->query($query);
        if (!$rs) {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        while ($fila = $rs->fetch_assoc()) {
            $usuario = self::buscaUsuario($fila['nombreUsuario']);
            $usuarios[] = $usuario;
        }
        $rs->free();
        return $usuarios;
    }

    private static function delete_directory($dirname) {
        if(file_exists($dirname)) {
            if (is_dir($dirname))
            $dir_handle = opendir($dirname);
            if (!$dir_handle)
                return false;
            while ($file = readdir($dir_handle))
                if ($file != "." && $file != "..")
                    unlink($dirname."/".$file);
            closedir($dir_handle);
            rmdir($dirname);
        }
    }
}
