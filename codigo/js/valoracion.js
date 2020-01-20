$(()=>{

    $( ".estrella" ).checkboxradio({
		icon: false
	});

    if($(".rate").length) {
        const caso = $(".rate").attr("id");
        let id;
        switch (caso){
            case 'rateArchivo':
                id = $(".embed").attr("id");
            break;
            case 'rateUsuario':
                id = $(".titulo").attr("id");
            break;
        }
        $.post("includes/ajax/procesaValoracion.php",
        { caso : caso, principio : 1, id : id, puntuacion : 0 },
            function(data) {
                let i = 1;
                for (; i <= data;) {
                    $("#star" + i).prop("checked", true);
                    $("#labelstar" + i).addClass("ui-checkboxradio-checked ui-state-active");
                    $("#labelstar" + i).html("<img class='star-img' alt='Marked star' src='img/validacion/markedstar.png'/>");
                    i++;
                }
            }
        );

        const estrella = $(".estrella");
        estrella.on('click', function(e){
            let i = 1;
            const numStarClicked = $(this).attr("id").substr(4);
            for (; i <= numStarClicked;) {
                $("#star" + i).prop("checked", true);
                $("#labelstar" + i).addClass("ui-checkboxradio-checked ui-state-active");
                $("#labelstar" + i).html("<img class='star-img' alt='Marked star' src='img/validacion/markedstar.png'/>");
                i++;
            }
            for (; i <= 6;) {
                $("#star" + i).prop("checked", false);
                $("#labelstar" + i).removeClass("ui-checkboxradio-checked ui-state-active");
                $("#labelstar" + i).html("<img class='star-img' alt='Unmarked star' src='img/validacion/unmarkedstar.png'/>");
                i++;
            }
            $.post("includes/ajax/procesaValoracion.php",
            { caso : caso, puntuacion : numStarClicked, id : id, principio : 0 },
                function(data) {
                    const spanMedia = document.getElementById("average");
                    spanMedia.innerHTML = "(" + data + ")";
                }
            );
        });
    }
});