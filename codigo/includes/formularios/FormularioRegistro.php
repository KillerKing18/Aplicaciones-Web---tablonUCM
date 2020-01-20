<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';
class FormularioRegistro extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        $usuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : "";
        $email = isset($_SESSION['emailUsuario']) ? $_SESSION['emailUsuario'] : "";
        return '<label>Nombre de usuario:</label> 
                <div class="div-validacion">
                    <input placeholder="Nombre de usuario" value="' . $usuario . '" type="text" class="validacion icono" id="usuarioRegistro" maxlength="15" name="usuario" required=""/>
                        <span id="iconousuarioRegistro" class="iconoValidacion"></span>
                </div>
                <label>E-mail:</label> 
                <div class="div-validacion">
                    <input placeholder="Email" value="' . $email . '" class="icono validacion" id="emailRegistro" type="email" name="email" maxlength="40" required=""/><span id="iconoemailRegistro" class="iconoValidacion"></span></div>
                <label>Contraseña:</label> 
                <div class="div-validacion">
                    <input placeholder="Contraseña" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*.{7}" maxlength="80" class="validacion" id="password1" name="password" required=""/>
                    <span id="iconopassword1" class="iconoValidacion"></span>
                </div>
                <label>Repetir contraseña:</label> 
                <div class="div-validacion">
                    <input placeholder="Repetir contraseña" type="password" class="validacion" id="password2" name="password2" id="password2" required=""/>
                        <span id="iconopassword2" class="iconoValidacion"></span>
                </div>
                <div id="boton">
                    <button id = "registro" type="submit" name="registro">Registrar</button>
                </div>
                <div id="link-login">
                    ¿Ya estás registrado? <a href="login.php">Iniciar sesión</a>
                </div>';
    }

    public function procesaFormulario($datos)
    {        
        $mensajesFormulario = array();

        $nombreUsuario = isset($_POST['usuario']) ?  htmlspecialchars(trim(strip_tags($_POST['usuario']))) : null;      
        $email = isset($_POST['email']) ? htmlspecialchars(trim(strip_tags($_POST['email']))) : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        
        if($password === $password2){
            $usuario = Usuario::crea($nombreUsuario, $email, $password, 'user');
            
            if (!$usuario) {
                $_SESSION['emailUsuario'] = $email;
                $mensajesFormulario[] = "Ya existe un usuario con el nombre introducido";
                $mensajesFormulario[] = "fracaso";
            }
            else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombreUsuario;
                $_SESSION['esAdmin'] = false;
                $_SESSION['seccion'] = 'inicio';
                if (isset($_SESSION['nombreUsuario']))
                    unset($_SESSION['nombreUsuario']);
                if (isset($_SESSION['emailUsuario']))
                    unset($_SESSION['emailUsuario']);
                echo "<script>document.location.href = 'inicio.php';</script>";
                exit();
            }
        }
        else {
            $_SESSION['nombreUsuario'] = $nombreUsuario;
            $_SESSION['emailUsuario'] = $email;
            $mensajesFormulario[] = "Las contraseñas no coinciden";
            $mensajesFormulario[] = "fracaso";
        }

        return $mensajesFormulario;
    }

}