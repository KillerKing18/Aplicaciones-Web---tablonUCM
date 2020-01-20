<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';

class FormularioPassword extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<p>Contraseña actual:</p>
                <input type="password" name="oldPassword" maxlength="80" required=""></input>
                <p>Contraseña nueva:</p>
                <div class="div-validacion"><input type="password" name="newPassword" id="password1" maxlength="80" class="validacion" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*.{7}" required=""><span id="iconopassword1" class="iconoValidacion"></span></div>
                <p>Repita la nueva contraseña:</p>
                <div class="div-validacion"><input type="password" name="newPassword2" id="password2" maxlength="80" class="validacion" required=""/><span id="iconopassword2" class="iconoValidacion"></span>
                <button type="submit" class="cambiar">Actualizar</button></div>';
    }

    public function procesaFormulario($datos)
    {
        $mensajesFormulario = array();

        $actual = $_REQUEST['oldPassword'];
        $nueva1 = $_REQUEST['newPassword'];
        $nueva2 = $_REQUEST['newPassword2'];
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        if($usuario->compruebaPassword($actual))
            if($usuario->compruebaPassword($nueva1)) {
                $mensajesFormulario[] = "Tu nueva contraseña no puede ser la misma que la antigua";
                $mensajesFormulario[] = "fracaso";
            }
            else
                if($nueva1 === $nueva2) {
                    $usuario->cambiaPassword($nueva1);
                    $mensajesFormulario[] = "Contraseña actualizada correctamente";
                    $mensajesFormulario[] = "exito";
                }
                else {
                    $mensajesFormulario[] = "Las nuevas contraseñas no coinciden";
                    $mensajesFormulario[] = "fracaso";
                }
        else {
            $mensajesFormulario[] = "No has escrito correctamente tu contraseña actual";
            $mensajesFormulario[] = "fracaso";
        }

        return $mensajesFormulario;
    }
}