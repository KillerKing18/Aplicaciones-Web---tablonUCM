<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';

class FormularioEmail extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<p>Nuevo email:</p>
                <div class="div-validacion"><input name="email" type="email" id="emailPerfil" maxlength="40" class="validacion icono" required=""><span id="iconoemailPerfil" class="iconoValidacion"></span>
                <button type="submit" class="cambiar">Actualizar</button></div>';
    }

    public function procesaFormulario($datos)
    {
        $mensajesFormulario = array();

        $email = $_REQUEST['email'];
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        if($usuario->email() !== $email) {
            $usuario->editarEmail($email);
            $mensajesFormulario[] = "Email actualizado correctamente";
            $mensajesFormulario[] = "exito";
        }
        else {
            $mensajesFormulario[] = "Tu nuevo email no puede ser el mismo que el antiguo";
            $mensajesFormulario[] = "fracaso";
        }

        return $mensajesFormulario;
    }
}