$(()=>{
    $("#form-search").on('submit', function(e){
        e.preventDefault();
        let asignatura = $("select").filter("#asignatura").val();

        $.post("includes/ajax/procesaBuscador.php",
            { asignatura : asignatura},
            function(data) {
                const array = JSON.parse(data);
                for (element in array)
                    if(element !== 'buscador-selectores')
                        document.getElementById(element).innerHTML = array[element];
                const divDescargarZipAsignatura = $("#div-descargar-zip-asignatura");
                if (divDescargarZipAsignatura.length) {
                    divDescargarZipAsignatura.remove();
                }
                const divMarcarAsignatura = $("#div-marcar-asignatura");
                if (divMarcarAsignatura.length) {
                    divMarcarAsignatura.remove();
                }
                const buscadorSelectores = $("#buscador-selectores");
                buscadorSelectores.append(array['buscador-selectores']);
                const botonMarcarAsignatura = document.getElementsByClassName("button-marcar-asignatura")[0];
                botonMarcarAsignatura.addEventListener("click", function(){
                    $.post("includes/ajax/procesaMarcadoAsignatura.php",
                        { idAsignatura : botonMarcarAsignatura.id},
                        function(marcada) {
                            if(marcada === '1') {
                                botonMarcarAsignatura.innerHTML = "Desmarcar asignatura";
                            }
                            else {
                                botonMarcarAsignatura.innerHTML = "Marcar asignatura";
                            }
                        }
                    );
                });
                var botones = document.getElementsByClassName("button-descargar-zip");
                let indice = 0;
                let categoria = "";
                for (let i = 0; i < botones.length; i++) {
                    document.getElementById(botones[i].id).addEventListener("click", function(){ 
                        indice = botones[i].id.lastIndexOf('-');
                        indice++;
                        categoria = botones[i].id.substr(indice);
                        document.getElementById("a-descargar-zip-" + categoria).click(); 
                    });
                }
            }
        );
    });
    $(".button-marcar-asignatura").on('click', function(e){
        alert('asignatura marcada');
    });
});