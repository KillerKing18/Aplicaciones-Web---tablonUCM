window.onload = function() {
    const resultados = document.getElementsByClassName("resultado-archivo");
    const titulo = document.getElementById("titulo");
    if (resultados.length && titulo)
        document.getElementById("button-descargar-zip-" + titulo.innerHTML).addEventListener("click", function(){ 
            document.getElementById("a-descargar-zip-" + titulo.innerHTML).click();
        });
    var button = document.getElementById("button-descargar-archivo");
    if (button)
        button.addEventListener("click", function(){ 
            document.getElementById("a-descargar-archivo").click();
        });
    var buttonZIP = document.getElementById("button-descargar-zip-asignatura-general");
    if (buttonZIP)
        buttonZIP.addEventListener("click", function(){ 
            document.getElementById("a-descargar-zip-asignatura").click();
        });
  };