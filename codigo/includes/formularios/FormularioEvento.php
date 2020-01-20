<?php
require_once __DIR__.'/../Form.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Evento.php';
require_once __DIR__.'/../Novedad.php';

class FormularioEvento extends Form {

    public function generaCamposFormulario($datosIniciales)
    {
        $optionsCategoria = Evento::creaOpcionesCategoria();
        $optionsHora = Evento::creaOpcionesHora();
        return  '   <div id="campos-evento">
                        <label>Nombre</label>
                        <input type="text" name="nombre" maxlength="30" required="">
                        <label>Categoría</label>
                        <select id="categoriasubir" name="categoria" class="selector" required>'
                            . $optionsCategoria .
                        '</select>
                        <label>Lugar</label>
                        <input type="text" name="lugar" maxlength="30" required="">
                        <label>Fecha</label>
                        <input autocomplete="off" type="text" name="fecha" id="datepicker" required="">
                        <label>Hora</label>
                        <select id="horasubir" name="hora" class="selector" required>'
                            . $optionsHora .
                        '</select>
                    </div>
                    <div id="observaciones">
                        <p id="descripcionEvento">Aquí podrás organizar eventos de distinto tipo como deportes, estudio o música a los que otros usuarios podrán apuntarse.
                        Describe bien el evento para que otros usuarios puedan saber en qué consiste.</p>    
                        <label>Descripción</label>
                        <textarea rows="7" name="descripcion" maxlength="140" required></textarea>
                        <div id="submit-button-evento">
                            <button type="submit" id="crearEvento">Crear evento</button>
                        </div>   
                    </div>';
    }

    public function procesaFormulario($datos)
    { 
        $mensajesFormulario = array();

        $nombre = $_REQUEST['nombre'];
        $categoria = $_REQUEST['categoria'];
        $lugar = $_REQUEST['lugar'];
        $fecha = substr($_REQUEST['fecha'], 6, 4) . '-' . substr($_REQUEST['fecha'], 0, 2) . '-' . substr($_REQUEST['fecha'], 3, 2);
        $hora = $_REQUEST['hora'] . ':00';
        $descripcion = $_REQUEST['descripcion'];

        $fechaActual = date("Y-m-d H:i:s");

        if((int)substr($fecha, 0, 4) < (int)substr($fechaActual, 0, 4) || ((int)substr($fechaActual, 0, 4) === (int)substr($fechaActual, 0, 4) && (int)substr($fecha, 5, 2) < (int)substr($fechaActual, 5, 2)) || ((int)substr($fecha, 0, 4) === (int)substr($fechaActual, 0, 4) && (int)substr($fecha, 5, 2) === (int)substr($fechaActual, 5, 2) && (int)substr($fecha, 8, 2) < (int)substr($fechaActual, 8, 2))) {
            $mensajesFormulario[] = "No puedes crear un evento con una fecha anterior a la actual";
            $mensajesFormulario[] = "fracaso";
        }
        else {
            $evento = Evento::crea($nombre, $categoria, $lugar, $fecha, $hora, $_SESSION['nombre'], $descripcion);

            Novedad::crearNovedad('novedadeseventos', 'idEvento', $evento->id());
    
            echo '<script>document.location.href = "resultadoEvento.php?id=' . $evento->id() . '";</script>';
        }

        return $mensajesFormulario;
    }

}