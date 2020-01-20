<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';

class FormularioNombreUsuario extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<p>Nuevo nombre de usuario:</p>
                <div class="div-validacion">
                    <input type="text" name="nombreUsuario" id="usuarioCambio" maxlength="15" class="validacion icono" required="">
                        <span id="iconousuarioCambio" class="iconoValidacion"></span>
                    <button type="submit" class="cambiar">Actualizar</button>
                </div>';
    }

    public function procesaFormulario($datos)
    {
        $mensajesFormulario = array();

        $nombreUsuario = $_REQUEST['nombreUsuario'];
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        $nombreUsuarioAntiguo = $usuario->nombreUsuario();
        if($usuario->nombreUsuario() !== $nombreUsuario){
            if($usuario->editarNombreUsuario($nombreUsuario)){
                $mensajesFormulario[] = "Nombre de usuario actualizado correctamente";
                $mensajesFormulario[] = "exito";
                $_SESSION['nombre'] = $nombreUsuario;
                if($usuario->extensionImagen() !== '')
                    rename('data/usuarios/'. $nombreUsuarioAntiguo . '.' . $usuario->extensionImagen(), 'data/usuarios/'. $nombreUsuario . '.' . $usuario->extensionImagen());  
            }
            else {
                $mensajesFormulario[] = "Ya existe otro usuario con el mismo nombre";
                $mensajesFormulario[] = "fracaso";
            }
        }
        else {
            $mensajesFormulario[] = "Tu nuevo nombre de usuario no puede ser el mismo que el antiguo";
            $mensajesFormulario[] = "fracaso";
        }

        return $mensajesFormulario;
    }
}