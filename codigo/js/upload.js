function extractFilename(path) {
      if (path.substr(0, 12) == "C:\\fakepath\\")
        return path.substr(12); // modern browser (google chrome)
      var x;
      x = path.lastIndexOf('/');
      if (x >= 0) // Unix-based path
        return path.substr(x+1);
      x = path.lastIndexOf('\\');
      if (x >= 0) // Windows-based path
        return path.substr(x+1);
      return path; // just the file name
}
  
$(()=>{
      const inputFileArchivo = $("#archivo");
      const botonSeleccionarArchivo = $("#examinar");
      const botonSubirArchivo = $("#subir");
      const inputStringArchivo = $("#upload-selected");

      inputFileArchivo.hide();
      
      botonSeleccionarArchivo.on('click', function(e){
          e.preventDefault();
          inputFileArchivo.trigger('click');
      });

      inputFileArchivo.on('change', function(e){
          inputStringArchivo.val(extractFilename($(this).val()));
      });

      botonSubirArchivo.on('click', function(e){
        if(inputFileArchivo.val() === "")
          botonSeleccionarArchivo[0].setCustomValidity("Debes seleccionar un archivo");
        else
          botonSeleccionarArchivo[0].setCustomValidity("");

        let nombreArchivo = inputStringArchivo.val().split(".")[0];

        if(nombreArchivo.length > 30)
          botonSeleccionarArchivo[0].setCustomValidity("El nombre del archivo no puede ser superior a 30 caracteres");
        else
          botonSeleccionarArchivo[0].setCustomValidity("");

      });
});