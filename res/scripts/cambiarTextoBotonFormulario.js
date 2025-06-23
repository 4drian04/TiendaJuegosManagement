function cambiarTextoBoton(form) {
    const inputs = form.querySelectorAll('input:not([type="submit"])');
    const boton = form.querySelector('input[type="submit"]');
    const arrayContenidoFormulario = document.querySelector('h2').textContent.split(" ");
    var contenidoFormulario = arrayContenidoFormulario[arrayContenidoFormulario.length - 1];
    contenidoFormulario=contenidoFormulario=='compra'?arrayContenidoFormulario[arrayContenidoFormulario.length - 3]+' '+arrayContenidoFormulario[arrayContenidoFormulario.length - 2]+' '+arrayContenidoFormulario[arrayContenidoFormulario.length - 1]:arrayContenidoFormulario[arrayContenidoFormulario.length - 1];
    let hayDatos = false;

    inputs.forEach(input => {
        if (input.value.trim() !== '') {
            hayDatos = true;
        }
    });

    boton.value = hayDatos ? 'Enviar' : ('Mostrar ' + (contenidoFormulario === 'compras' || contenidoFormulario == 'líneas de compra' ? 'todas las ' : 'todos los ') + contenidoFormulario);
}

// Añadir eventos a todos los inputs después de que el DOM esté completamente cargado
const form = document.querySelector('form');
const inputs = form.querySelectorAll('input:not([type="submit"])');

inputs.forEach(input => {
    input.addEventListener('input', () => cambiarTextoBoton(form));
});