// Para mostrar la informacion actualizada en caso de que se haya actualizado
// el nombre de usuario, el email o la imagen, debemos obtener esa informacion
// despues de que se llame a los metodos gestiona de cada uno de estos formularios.
// De lo contrario, estariamos obteniendo la informacion de antes de actualizar.
// Para ello usamos este jquery para coger el html del de info provisional y darselo 
// al div de info final, para que se muestre la informacion antes que los formularios.
$(()=>{
    const provisional = $("#provisional");
    const infoPerfil = provisional.html();
    provisional.html('');
    const final = $("#final");
    final.html(infoPerfil);

    const formularioCambiarImagen = $("#form-imagen");
    formularioCambiarImagen.attr("enctype", "multipart/form-data");

    const botonSeleccionarArchivoCambioImagen = $("#cambiarImagen");
    botonSeleccionarArchivoCambioImagen.hide();

    const botonCambiarImagen = $("#subirImagen");
    botonCambiarImagen.on('click', function(e){
        e.preventDefault();
        botonSeleccionarArchivoCambioImagen.trigger('click');
    });

    botonSeleccionarArchivoCambioImagen.change(function() {
        formularioCambiarImagen.submit();
    });

    const formularioBorrarCuenta = $("#form-borrarCuenta");
    formularioBorrarCuenta.on('submit', function(e){
        if(!confirm('¿Estás seguro/a de que quieres borrar tu cuenta?'))
            return false;
    });
});