$(()=>{
    const formularioBorrarCuenta = $("#form-borrarCuenta");
    formularioBorrarCuenta.on('submit', function(e){
        if(!confirm('¿Estás seguro/a de que quieres borrar esta cuenta?'))
            return false;
    });
});