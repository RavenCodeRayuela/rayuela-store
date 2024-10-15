 
 // Funcion para mostrar el formulario correspondiente
 function mostrarFormulario(formularioId) {

    // Ocultar todos los formularios mediante una funcion anonima
    var formularios = document.querySelectorAll('.form-container-productos');
    formularios.forEach(function(formulario) {
        formulario.style.display = 'none';
    });

    // Mostrar solo el formulario correspondiente
    var formularioSeleccionado = document.getElementById(formularioId);
    formularioSeleccionado.style.display = 'block';
}


