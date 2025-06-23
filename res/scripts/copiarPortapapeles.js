function copiarTexto(textoACopiar) {
    // Selecciona el texto del elemento
    const texto = document.getElementById(textoACopiar).innerText;

    // Crea un elemento de texto temporal
    const elementoTemporal = document.createElement("textarea");
    elementoTemporal.value = texto;
    document.body.appendChild(elementoTemporal);

    // Selecciona el texto del elemento temporal
    elementoTemporal.select();
    elementoTemporal.setSelectionRange(0, 99999); // Para dispositivos móviles

    // Copia el texto al portapapeles
    document.execCommand("copy");

    // Elimina el elemento temporal
    document.body.removeChild(elementoTemporal);

    //Notificación de éxito
    //alert("Texto copiado: " + texto);
}