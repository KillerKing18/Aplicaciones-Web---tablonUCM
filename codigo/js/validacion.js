$(()=>{
    const iconosValidacion = $(".iconoValidacion");
    const password1 = $("#password1");
    const campoValidacion = $(".validacion");

    iconosValidacion.hide();

    password1.on("invalid", function(e) {
        $(this)[0].setCustomValidity("La contraseña debe tener una longitud mínima de 7 caracteres y contener al menos un dígito, una letra minúscula y una letra mayúscula");
        const iconoValidacionPaswword2 = $("#iconopassword2");
        iconoValidacionPaswword2.html("<img alt='Logo error' src='img/validacion/errorcross.png'/>");
    });

    campoValidacion.on("input", function(e) {
        const campoActual = $("#" + $(this).attr("id"));
        campoActual[0].setCustomValidity("");
        let text = campoActual.val();
        let id = campoActual.attr("id");
        let idArchivo = "";
        let idEvento = "";
        let otherPasswordID = "";
        let otherPasswordText = "";
        let otherPassword;
        let iconoOtherPassword;
        if(typeof id !== 'undefined') {
            switch(id){
                case "eventoCambioNombre":
                case "eventoCambioLugar":
                case "eventoCambioDescripcion":
                    idEvento = parseInt(campoActual[0].dataset.idEvento);
                    break;
                case "archivoCambioNombre":
                case "archivoCambioObservaciones":
                    idArchivo = parseInt(campoActual[0].dataset.idArchivo);
                    break;
                case "password1":
                    otherPasswordID = "password2";
                    break;
                case "password2":
                    otherPasswordID = "password1";
                    break;
            }
            $.post("includes/ajax/procesaValidacion.php",
                { caso : id, text : text, idArchivo : idArchivo, idEvento : idEvento},
                function(data) {
                    if (id === "usuarioRegistro")
                        campoActual[0].setCustomValidity(data == 1 ? "Ya existe un usuario con ese nombre" : "");
                    else if (id === "usuarioCambio") {
                        if (data == -1)
                            campoActual[0].setCustomValidity("Tu nuevo nombre de usuario no puede ser el mismo que el antiguo");
                        else if (data == 0)
                            campoActual[0].setCustomValidity("");
                        else if (data == 1)
                            campoActual[0].setCustomValidity("Ya existe un usuario con ese nombre");
                    }
                    else if (id === "emailPerfil")
                        campoActual[0].setCustomValidity(data == 1 ? "Tu nuevo email no puede ser el mismo que el antiguo" : "");
                    else if (id === "archivoCambioNombre")
                        campoActual[0].setCustomValidity(data == 1 ? "El nuevo nombre no puede ser el mismo que el antiguo" : "");
                    else if (id === "archivoCambioObservaciones")
                        campoActual[0].setCustomValidity(data == 1 ? "Las observaciones no pueden ser las mismas que las antiguas" : "");
                    else if (id === "eventoCambioNombre")
                        campoActual[0].setCustomValidity(data == 1 ? "El nuevo nombre no puede ser el mismo que el antiguo" : "");
                    else if (id === "eventoCambioLugar")
                        campoActual[0].setCustomValidity(data == 1 ? "El nuevo lugar no puede ser el mismo que el antiguo" : "");
                    else if (id === "eventoCambioDescripcion")
                        campoActual[0].setCustomValidity(data == 1 ? "La descripción no puede ser la misma que la antigua" : "");

                    if (otherPasswordID !== "") {
                        otherPassword = $("#" + otherPasswordID);
                        otherPasswordText = otherPassword.val();
                        iconoOtherPassword = $("#icono" + otherPasswordID);
                        if (id === "password2")
                            campoActual[0].setCustomValidity(text === otherPasswordText ? "" : "Las contraseñas no coinciden");
                        else if (id === "password1") {
                            const password2 = $("#password2");
                            password2[0].setCustomValidity(text === otherPasswordText ? "" : "Las contraseñas no coinciden");
                        }
                    }
                    
                    const iconoValidacion = $("#icono" + id);
                    if (text === "")
                        iconoValidacion.hide();
                    else {
                        iconoValidacion.show();
                        if(campoActual[0].checkValidity()) {
                            iconoValidacion.html("<img alt='Logo correcto' src='img/validacion/tick.png'/>");
                            if (otherPasswordID !== "")
                                if (otherPassword[0].checkValidity())
                                    iconoOtherPassword.html("<img alt='Logo correcto' src='img/validacion/tick.png'/>");
                                else
                                    iconoOtherPassword.html("<img alt='Logo error' src='img/validacion/errorcross.png'/>");
                        }
                        else
                            iconoValidacion.html("<img alt='Logo error' src='img/validacion/errorcross.png'/>");
                    }  
                }
            );
        }
    });
});