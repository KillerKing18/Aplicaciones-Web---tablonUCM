function firstLetterCapital(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$(()=>{
    $(".editor").on('click', function(e){
        const idObjeto = parseInt($(this).attr("id"));
        const accion = $(this)[0].dataset.accion;
        const objeto = $(this)[0].dataset.objeto;
        if (accion === "editar")
            document.location.href = 'editar' + firstLetterCapital(objeto) + '.php?id=' + idObjeto;
        else if (accion === "borrar") {
            if(!confirm('¿Estás seguro/a de que quieres borrar el ' + objeto + '?'))
                return false;
            $.post("includes/ajax/procesaBorrado" + firstLetterCapital(objeto) + ".php",
                    { id : idObjeto},
                    function(link) {
                        document.location.href = link;
            });
        }
    });
});