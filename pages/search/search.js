// search.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('searchBarContainer');
    const searchInput = document.getElementById('search-input');
    const categorySelect = document.getElementById('category-select');

    form.addEventListener('submit', (event) => {
        let isValid = true;
        let errorMessage = '';

        // Validar que el campo de búsqueda no esté vacío
        if (searchInput.value.trim() === '') {
            errorMessage += 'El campo de búsqueda no puede estar vacío.\n';
            isValid = false;
        }

        // Validar que se haya seleccionado una categoría
        if (categorySelect.value === '') {
            errorMessage += 'Debe seleccionar una categoría.\n';
            isValid = false;
        }

        // Si hay errores, mostrar alerta y prevenir el envío del formulario
        if (!isValid) {
            alert(errorMessage);
            event.preventDefault(); // Prevenir el envío del formulario
        }
    });
});
