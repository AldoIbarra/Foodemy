

document.addEventListener('DOMContentLoaded', () => {
    // Selecciona todos los botones "Ver detalles"
    const detailButtons = document.querySelectorAll('.red-button');

    // Agrega un evento de clic a cada botón
    detailButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            // Prevenir la acción por defecto del botón (si es necesario)
            event.preventDefault();

            // Mostrar alerta
            alert('Se abrirá una nueva ventana con más detalles del curso.');
        });
    });
});
