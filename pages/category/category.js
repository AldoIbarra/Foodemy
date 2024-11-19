document.addEventListener("DOMContentLoaded", function () {
    const categoriesContainer = document.getElementById('dynamic-categories-container');
    const numberOfCategories = document.getElementById('number-of-categories');

    let allCategories = [];

    // Fetch initial categories
    const params = new URLSearchParams({ option: 'getAllCategories' });
    $.ajax({
        type: "GET",
        url: "../../api/categoryController.php?" + params.toString(),
        dataType: "json",
        success: function (response) {
            if (response.success && Array.isArray(response.categories)) {
                allCategories = response.categories;
                response.categories.forEach(category => addCategoryToSelect(category));
                addCategoryToSelect({ ID_Categoria: '', Titulo: '+ Agregar' });
            } else {
                console.error('Error al cargar categorías:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });

    function addCategoryToSelect(category) {
        const option = document.createElement('option');
        option.value = category.ID_Categoria;
        option.textContent = category.Titulo;
        numberOfCategories.appendChild(option);
    }

    numberOfCategories.addEventListener('change', function () {
        const selectedCategoryId = numberOfCategories.value;
        if (selectedCategoryId === '') {
            addCategoryForm();
        } else {
            const selectedCategory = allCategories.find(cat => cat.ID_Categoria == selectedCategoryId);
            if (selectedCategory) displayCategory(selectedCategory);
        }
    });

    function addCategoryForm() {
        categoriesContainer.innerHTML = `
            <div class="category">
                <h4 class="name eerie" >Agregar nueva Categoría</h4>
                <div class="input-box">
                    <span class="description eerie">Título</span>
                    <input type="text" id="new-category-title" placeholder="Ingrese el título de la categoría" class="input-field title_input" required>
                </div>
                <div class="input-box">
                    <span class="description eerie">Descripción</span>
                    <input type="text" id="new-category-description" placeholder="Ingrese la descripción de la categoría" class="input-field desc_input" required>
                </div>
                <div class="button-container">
                <button id="save-category" class="red-button save-btn">Guardar</button>
                </div>
            </div>`;
        document.getElementById('save-category').addEventListener('click', saveCategory);
    }

    function saveCategory() {
        const title = document.getElementById('new-category-title').value;
        const description = document.getElementById('new-category-description').value;
        if (!title || !description) {
            alert('Por favor, completa todos los campos.');
            return;
        }
        const formData = new FormData();
        formData.append('title', title);
        formData.append('description', description);
        formData.append('option', 'createCategory');
        $.ajax({
            type: "POST",
            url: "../../api/categoryController.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    alert('¡Categoría creada con éxito!');
                    addCategoryToSelect({ ID_Categoria: response.newCategoryId, Titulo: title });
                } else {
                    alert('Error al crear la categoría.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
                var errorResponse = JSON.parse(xhr.responseText);
        alert('Error en la solicitud: ' + errorResponse.message);
            }
        });
    }

    function displayCategory(category) {
        categoriesContainer.innerHTML = `
            <div class="category" data-id="${category.ID_Categoria}">
                <h4 class="name eerie">${category.Titulo}</h4>
                <div class="input-box">
                    <span class="description eerie">Título</span>
                    <input type="text" value="${category.Titulo}" class="input-field category_title" readonly>
                </div>
                 <div class="input-box">
                    <span class="description eerie">Descripción</span>
                    <input type="text" value="${category.Descripcion}" class="input-field category_desc" readonly>
                </div>
                <br>
                <button class="red-button edit-btn">Editar</button>
                <button class="red-button delete-btn">Eliminar</button>
            </div>`;

        const editBtn = categoriesContainer.querySelector('.edit-btn');
        const deleteBtn = categoriesContainer.querySelector('.delete-btn');
        editBtn.addEventListener('click', () => toggleEditMode(category.ID_Categoria));
        deleteBtn.addEventListener('click', () => deleteCategory(category.ID_Categoria));
    }

    function toggleEditMode(categoryId) {
        const categoryElement = document.querySelector(`.category[data-id="${categoryId}"]`);
        let titleInput = categoryElement.querySelector('.category_title');
        let descriptionInput = categoryElement.querySelector('.category_desc');
        const editBtn = categoryElement.querySelector('.edit-btn');

        if (editBtn.textContent === 'Editar') {
            // Enable editing
            titleInput.readOnly = false;
            descriptionInput.readOnly = false;
            editBtn.textContent = 'Guardar';

            titleInput = categoryElement.querySelector('.category-title');
            descriptionInput = categoryElement.querySelector('.category-description');
        } else {
            if (!titleInput.value || !descriptionInput.value) {
                alert('Por favor, completa todos los campos.');
                return;
            }
            // Save changes
            console.log(categoryId, titleInput.value, descriptionInput.value)
            const updatedCategory = {
                id_category: categoryId,
                title: titleInput.value,
                description: descriptionInput.value
            };
            $.ajax({
                type: "POST",
                url: "../../api/categoryController.php",
                data: { option: 'updateCategory', ...updatedCategory },
                success: function (response) {
                    if (response.success) {
                        alert('Categoría actualizada correctamente.');
                        titleInput.readOnly = true;
                        descriptionInput.readOnly = true;
                        editBtn.textContent = 'Editar';
                    } else {
                        alert('Error al actualizar la categoría.');
                    }
                }
            });
        }
    }

    function deleteCategory(categoryId) {
        if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
            $.ajax({
                type: "POST",
                url: "../../api/categoryController.php",
                data: { option: 'deleteCategory', id_category: categoryId },
                success: function (response) {
                    if (response.success) {
                        alert('Categoría eliminada con éxito.');
                        document.querySelector(`.category[data-id="${categoryId}"]`).remove();
                    } else {
                        alert('Error al eliminar la categoría.');
                    }
                }
            });
        }
    }
});
