<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';
class FormularioLogin extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        $usuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : "";
        return '<label>Nombre de usuario:</label>
                <input placeholder="Nombre de usuario" value="' . $usuario . '" type="text" class="icono" id="usuarioLogin" maxlength="15" name="usuario" required=""/>
                <label>Contraseña:</label>
                <input placeholder="Contraseña" type="password" maxlength="80" name="password" required=""/>
                <div id="boton">
                    <button id="login" type="submit">Iniciar sesión</button>
                </div>
                <div id="link-registro">
                    ¿No estás registrado?
                    <a href="registro.php">Regístrate</a>
                </div>';
    }

    public function procesaFormulario($datos)
    {        
        $mensajesFormulario = array();
        
        $nombreUsuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;
		
		$usuario = Usuario::buscaUsuario($nombreUsuario);
    
        if($usuario){
            if ($usuario->compruebaPassword($password)) {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombreUsuario;
                $_SESSION['esAdmin'] = strcmp($usuario->rol(), 'admin') == 0 ? true : false;
                $_SESSION['seccion'] = 'inicio';
                if (isset($_SESSION['nombreUsuario']))
                    unset($_SESSION['nombreUsuario']);
                echo "<script>document.location.href = 'inicio.php';</script>";
                exit();
            }
            else {
                $_SESSION['nombreUsuario'] = $nombreUsuario;
                $mensajesFormulario[] = "El usuario y la contraseña no coinciden";
                $mensajesFormulario[] = "fracaso";
            }
        }
        else {
            unset($_SESSION['nombreUsuario']);
            $mensajesFormulario[] = "El usuario y la contraseña no coinciden"; // No existe ningún usuario con ese nombre (no se lo decimos al cliente para evitar ataques de fuerza bruta)
            $mensajesFormulario[] = "fracaso";
        }
        
        return $mensajesFormulario;
    }

}