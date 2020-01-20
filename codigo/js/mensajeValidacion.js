$(()=>{
        const spanMensajesFormulario = $("#spanMensajes");
        const divMensajesFormulario = $("#divMensajes");
        if(spanMensajesFormulario.length){
                spanMensajesFormulario.hide();
                const mensajes = spanMensajesFormulario.html();
                const clase = spanMensajesFormulario.attr("name");
                divMensajesFormulario.addClass(clase);
                divMensajesFormulario.html(mensajes);
        }
        else
                divMensajesFormulario.hide();
});