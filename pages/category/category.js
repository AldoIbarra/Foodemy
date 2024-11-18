document.addEventListener("DOMContentLoaded", function () {
    const categoriesContainer = document.getElementById('dynamic-categories-container');
    const numberOfCategories = document.getElementById('number-of-categories');

    // Variable para almacenar todas las categorías
    let allCategories = [];

    // Usamos URLSearchParams para enviar el parámetro 'option'
    const params = new URLSearchParams();
    params.append('option', 'getAllCategories');

    $.ajax({
        type: "GET",
        url: "../../api/categoryController.php?" + params.toString(),
        dataType: "json", // Asegúrate de que los datos se manejen como JSON
        success: function(response) {
            try {
                console.log("Respuesta:", response); // Verifica qué es lo que llega
                
                // Verifica que response.success es verdadero y que response.categories es un array
                if (response.success && Array.isArray(response.categories)) {
                    allCategories = response.categories;  // Almacenamos todas las categorías
                    
                    response.categories.forEach(category => { 
                        console.log("Categoría:", category);
                        addCategoryToSelect(category);
                    });
                    // Añadir la opción "+ Agregar"
                    addCategoryToSelect({ ID_Categoria: '', Titulo: '+ Agregar' });
                } else {
                    console.log('Respuesta inesperada:', response);
                }
            } catch (error) {
                console.error('Error al procesar la respuesta:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });

    function addCategoryToSelect(category) {
        const option = document.createElement('option');
        option.value = category.ID_Categoria; // Asegúrate de usar las propiedades correctas
        option.textContent = category.Titulo; // Asegúrate de usar las propiedades correctas
        numberOfCategories.appendChild(option);
    }

    numberOfCategories.addEventListener('change', function () {
        const selectedCategoryId = numberOfCategories.value;
        if (selectedCategoryId === '') {
            addCategoryForm(); // Si no se seleccionó categoría, muestra el formulario para agregar
        } else {
            // Aquí obtenemos la categoría seleccionada de los datos almacenados
            const selectedCategory = allCategories.find(category => category.ID_Categoria == selectedCategoryId);
            if (selectedCategory) {
                displayCategory(selectedCategory);
            }
        }
    });

    function addCategoryForm() {
        categoriesContainer.innerHTML = `
            <div class="category">
                <h4>Agregar nueva Categoría</h4>
                <input type="text" id="new-category-title" placeholder="Título" required>
                <input type="text" id="new-category-description" placeholder="Descripción" required>
                <button id="save-category">Guardar</button>
            </div>`;
        document.getElementById('save-category').addEventListener('click', saveCategory);
    }

    function saveCategory() {
        const title = document.getElementById('new-category-title').value;
        const description = document.getElementById('new-category-description').value;
    
        if (!title || !description) {
            alert('Por favor completa todos los campos');
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
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                if (response.success) {
                    alert('¡Categoría registrada con éxito!');
                    
                    // Verificar si el nuevo ID de categoría llega correctamente
                    console.log('Nuevo ID de categoría:', response.newCategoryId);
                    
                    // Crear la nueva categoría con el ID recibido
                    const newCategory = {
                        ID_Categoria: response.newCategoryId,  // Usar el ID recibido
                        Titulo: title
                    };
            
                    // Añadir la nueva categoría al select
                    addCategoryToSelect(newCategory);
            
                    // Limpiar los campos del formulario
                    document.getElementById('new-category-title').value = '';  
                    document.getElementById('new-category-description').value = '';
            
                    // Redirigir después de unos segundos
                    setTimeout(function() {
                        window.location.replace("../category/category.php");  // Redirigir después de unos segundos
                    }, 1000); // 1 segundo
                } else {
                    alert('Error al crear la categoría');
                }
            }
            
        });
    }
   

    function displayCategory(category) {
        categoriesContainer.innerHTML = `
            <div class="category" data-id="${category.ID_Categoria}">
                <h4>${category.Titulo}</h4>
                <p>${category.Descripcion}</p>
                <button class="edit-btn" data-id="${category.ID_Categoria}">Editar</button>
                <button class="delete-btn" data-id="${category.ID_Categoria}">Eliminar</button>
            </div>`;
    }
});
