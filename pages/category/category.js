document.addEventListener("DOMContentLoaded", function () {
    const categoriesContainer = document.getElementById('dynamic-categories-container');

    const categoriesData = {
        "1": { title: "Cocina Saludable", description: "Enfocado en recetas y técnicas para preparar comidas balanceadas, bajas en calorías y ricas en nutrientes." },
        "2": { title: "Cocina Internacional", description: "Explora recetas y técnicas culinarias de diversas culturas alrededor del mundo, desde la cocina italiana hasta la japonesa." },
        "3": { title: "Repostería y Pastelería", description: "Aprende a hacer postres y dulces como pasteles, galletas, tartas y más, con técnicas de decoración y presentación." },
        "4": { title: "Cocina Vegetariana y Vegana", description: "Curso dedicado a preparar comidas sin carne ni productos animales, incluyendo alternativas nutritivas y sabrosas." },
        "5": { title: "Técnicas de Cocina Básicas", description: "Fundamentos de la cocina, desde cómo cortar ingredientes hasta técnicas de cocción esenciales." },
        "6": { title: "Cocina de Temporada", description: "Preparación de platos utilizando ingredientes frescos y de temporada, adaptados a cada estación del año." },
        "7": { title: "Platos Rápidos", description: "Recetas y técnicas para preparar comidas rápidas y deliciosas, ideales para quienes tienen poco tiempo para cocinar." },
    };

    const numberOfCategories = document.getElementById('number-of-categories');
    numberOfCategories.addEventListener('change', function () {
        categoriesContainer.innerHTML = ''; // Limpiar contenido previo
        const selectedValue = numberOfCategories.value;

        if (selectedValue === "+ Agregar") {
            // Mostrar un nuevo formulario para agregar una nueva categoría
            addCategoryForm();
        } else if (categoriesData[selectedValue]) {
            // Mostrar la categoría seleccionada
            displayCategory(categoriesData[selectedValue], selectedValue);
        }
    });

    function addCategoryForm() {
        const formHtml = `
            <div class="category">
                <h4 class="name eerie" >Agregar nueva Categoría</h4>
                <div class="input-box">
                    <span class="description eerie">Título</span>
                    <input type="text" placeholder="Ingrese el título de la categoría" class="input-field title_input" required>
                </div>
                <div class="input-box">
                    <span class="description eerie">Descripción</span>
                    <input type="text" placeholder="Ingrese la descripción de la categoría" class="input-field desc_input" required>
                </div>
                <div class="button-container">
                <button class="red-button save-btn">Guardar</button>
                </div>
            </div>
        `;
        categoriesContainer.innerHTML = formHtml;
    }
    

    categoriesContainer.addEventListener('click', function (event) {
        const target = event.target;

        if (target.classList.contains('save-btn')) {
            const titleInput = categoriesContainer.querySelector('.title_input');
            const descInput = categoriesContainer.querySelector('.desc_input');

            // Validaciones
            let hasError = false;

            if (titleInput.value.trim() === "") {
                titleInput.classList.add('error');
                hasError = true;
            } else {
                titleInput.classList.remove('error');
            }

            if (descInput.value.trim() === "") {
                descInput.classList.add('error');
                hasError = true;
            } else {
                descInput.classList.remove('error');
            }

            if (hasError) {
                alert('Favor de completar todos los campos.');
            } else {
                titleInput.value = "";
                descInput.value = "";
                alert('Nueva categoría guardada.');
                // Lógica para añadir la categoría al objeto o backend
            }
        }

        if (target.classList.contains('edit-btn') || target.classList.contains('save-edit-btn') || target.classList.contains('delete-btn')) {
            const parent = target.closest('.category');

            if (target.classList.contains('edit-btn')) {
                parent.querySelectorAll('input').forEach(input => input.readOnly = false);
                target.textContent = 'Guardar';
                target.classList.remove('edit-btn');
                target.classList.add('save-edit-btn');

            } else if (target.classList.contains('save-edit-btn')) {
                const titleInput = parent.querySelector('.category_title');
                const descInput = parent.querySelector('.category_desc');

                let hasError = false;

                if (titleInput.value.trim() === "") {
                    titleInput.classList.add('error');
                    hasError = true;
                } else {
                    titleInput.classList.remove('error');
                }

                if (descInput.value.trim() === "") {
                    descInput.classList.add('error');
                    hasError = true;
                } else {
                    descInput.classList.remove('error');
                }

                if (hasError) {
                    alert('Favor de completar todos los campos.');
                } else {
                    alert('Cambios guardados.');
                    parent.querySelectorAll('input').forEach(input => input.readOnly = true);
                    target.textContent = 'Editar';
                    target.classList.remove('save-edit-btn');
                    target.classList.add('edit-btn');
                }
            } else if (target.classList.contains('delete-btn')) {
                if (confirm('¿Estás seguro de que deseas ELIMINAR esta categoría?')) {
                    parent.remove();
                    alert('Categoría eliminada.');
                }
            }
        }
    });

    function displayCategory(category, categoryId) {
        const categoryHtml = `
            <div class="category" data-category-id="${categoryId}">
                <h4 class="name eerie">${category.title}</h4>
                <div class="input-box">
                    <span class="description eerie">Título</span>
                    <input type="text" value="${category.title}" class="input-field category_title" readonly>
                </div>
                <div class="input-box">
                    <span class="description eerie">Descripción</span>
                    <input type="text" value="${category.description}" class="input-field category_desc" readonly>
                </div>
                <div class="button-container">
                    <button class="red-button edit-btn">Editar</button>
                    <button class="red-button delete-btn">Eliminar</button>
                </div>
            </div>
        `;
        categoriesContainer.innerHTML += categoryHtml;
    }
    
});
