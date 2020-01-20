$(()=>{
    const apuntar = $("#apuntarEvento");
    apuntar.on('click', function(e){
        id = $(".titulo").attr("id");
        $.post("includes/ajax/procesaAsistentes.php",
        { id : id },
            function(data) {
                const array = JSON.parse(data);
                const asistentes = document.getElementById("asistentes");
                asistentes.innerHTML = array[0];
                const botonApuntarse = document.getElementById("apuntarEvento");
                botonApuntarse.innerHTML = array[1];
            }
        );
    });
});