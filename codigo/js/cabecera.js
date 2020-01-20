$(()=>{
    const anteriorIconoActivo = $(".icono-cabecera.active");
    anteriorIconoActivo.removeClass("active");
        
    $.post("includes/ajax/procesaSeccion.php",
                { },
                function(data) {
                    const nuevoIconoActivo = $("#" + data);
                    nuevoIconoActivo.addClass("active");
        });
});