<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuario.php';

class FormularioImagen extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<input type="file" id="cambiarImagen" name="imagen" accept="image/*">';
    }

    public function procesaFormulario($datos)
    {
        $mensajesFormulario = array();

        $image_name = $_FILES['imagen']['name'];
        $image_size = $_FILES['imagen']['size'];
        $image_tmp = $_FILES['imagen']['tmp_name'];
        $tmp_image_ext = explode('.', $image_name);
        $image_ext = strtolower(end($tmp_image_ext));

        $finfo = new finfo(FILEINFO_MIME);
        $type = $finfo->file($image_tmp);
        $type = substr($type, 0, 5);

        if($type !== 'image'){
            $mensajesFormulario[] = "Debes subir un archivo de imagen";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
            $extensionAntigua = $usuario->extensionImagen();
            if($extensionAntigua !== '' && $extensionAntigua !== $image_ext) // Si ha cambiado la extension del archivo, borramos el anterior
                unlink('data/usuarios/' . $usuario->nombreUsuario() . '.' . $extensionAntigua);

            $usuario->editarImagen($image_ext);

            $carpeta = 'data/usuarios';

            if (!file_exists('data/'))
                mkdir('data');
            if (!file_exists($carpeta . '/'))
                mkdir('data/usuarios');

            if(!move_uploaded_file($image_tmp, $carpeta . '/' . $usuario->nombreUsuario() . '.' . $image_ext)) {
                $mensajesFormulario[] = "Se ha producido un error al subir la imagen";
                $mensajesFormulario[] = "fracaso";
            }
            else {
                $mensajesFormulario[] = "La imagen de perfil se ha actualizado correctamente";
                $mensajesFormulario[] = "exito";
            }
        }
        return $mensajesFormulario;
    }
}