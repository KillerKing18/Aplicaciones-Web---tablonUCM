$(()=>{
    const selector = $(".selector");
    selector.change(function() {
        const id = '#' + this.id;
        if(this.id !== 'asignaturaBorrarAsignatura') {
            const formulario = this.dataset.caso;
            const caso = this.id.substr(0, this.id.length - formulario.length);
            let facultad = $("#facultad" + formulario).val();
            let grado = $("#grado" + formulario).val();
            let curso = $("#curso" + formulario).val();
            $.post("includes/ajax/procesaSelectores.php",
                { caso : caso, facultad : facultad, grado : grado, curso : curso},
                function(data) {
                    $(id).nextAll(".selector:first").html(data); // Rellenamos el siguiente selector con las opciones según lo que el usuario ha elegido en el selector anterior

                    $(id).nextAll(".selector:first").prop("disabled", false); // Habilitamos el siguiente selector

                    $(id).nextAll(".selector").nextAll(".selector").prop("disabled", true); // Deshabilitamos todos los selectores siguientes al siguiente selector que el usuario ha cambiado
                    $(id).nextAll(".selector").nextAll(".selector").prop("value", ""); // Marcamos la primera opción ("Elija un...") en los selectores mencionados anteriormente
                }
            );
        }
    });
});