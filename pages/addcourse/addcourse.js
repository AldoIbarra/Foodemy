document.addEventListener("DOMContentLoaded", function () {
    const numberOfCategories = document.getElementById('course-category');

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

    // Inicialmente ocultar el formulario de niveles
    $("#addlevel").hide();

    // Mostrar/ocultar el formulario de niveles
    $("#show-form").click(function() {
        $("#addlevel").slideToggle("slow");
    });

    // Detectar cuando el usuario elige la cantidad de niveles
    $("#level-count").change(function() {
        var numLevels = $(this).val();
        $("#addlevel").empty();  // Limpiar cualquier formulario previo

        if (numLevels > 0) {
            // Mostrar formularios para los niveles seleccionados
            for (let i = 1; i <= numLevels ; i++) {
                $("#addlevel").append(`
                    <form action="" class="level-info" id="level-form-${i}">
                        <h2>Nivel ${i}</h2>
                        <div class="title-price-container">
                            <input type="text" id="level-title-${i}" class="description" placeholder="Titulo del nivel">
                            <input type="number" id="level-price-${i}" class="description" placeholder="Precio">
                        </div>
                        <textarea id="level-desc-${i}" class="description" placeholder="Descripción..."></textarea>
                        <div class="file-zone">
                            <label for="level-video-${i}" class="description baby">Video del nivel</label>
                            <input type="file" id="level-video-${i}" name="level-video-${i}" accept="video/mp4,video/avi,video/mov,video/mkv,video/webm">
                        </div>
                        <div class="file-zone">
                            <label for="level-file-${i}" class="description baby">Archivo relacionado</label>
                            <input type="file" id="level-file-${i}" name="level-file-${i}">
                        </div>
                    </form>
                `);
                $("#addlevel").slideDown();
            }
        }
    });

    // Validación y envío de formulario
    $("#save-course").click(function() {
        // Validar los datos básicos del curso
        if ($("#course-title").val() == '' || $("#course-desc").val() == '' || $("#course-img").val() == '' || $("#course-price").val() == '' || $("#course-category").val() == '') {
            alert('Faltan algunos datos del curso');
        } else if ($("#level-count").val() == 0 || $("#level-count").val() == '') {  // Verificar que se haya seleccionado al menos un nivel
            alert('Debe agregar al menos un nivel');
        } else {
            // Validar los niveles
            let allLevelsValid = true;
            let levelsData = [];
        
            // Recorremos cada formulario de nivel
            $("form[id^='level-form-']").each(function() {
                let levelTitle = $(this).find("input[id^='level-title-']").val();
                let levelDesc = $(this).find("textarea").val();
                let levelPrice = $(this).find("input[id^='level-price-']").val();
                let levelVideo = $(this).find("input[id^='level-video-']").val();
                let levelFile = $(this).find("input[id^='level-file-']").val();
        
                // Comprobamos si falta algún campo en el nivel
                if (levelTitle == '' || levelDesc == '' || levelPrice == '' || levelVideo == '') {
                    allLevelsValid = false;
                    return false; // Salir del ciclo si falta algún dato
                }
        
                // Guardamos los datos de cada nivel
                levelsData.push({
                    title: levelTitle,
                    description: levelDesc,
                    price: levelPrice,
                    video: levelVideo,
                    file: levelFile
                });
            });
        
            // Si todos los niveles son válidos
            if (allLevelsValid) {
                // Crear el FormData para enviar los datos
                let formData = new FormData();
                
                // Agregar los datos del curso
                formData.append('title', $("#course-title").val());
                formData.append('description', $("#course-desc").val());
                formData.append('image', $("#course-img")[0].files[0]); // Imagen seleccionada
                formData.append('price', $("#course-price").val());
                formData.append('category', $("#course-category").val());
                
                // Agregar los niveles
                levelsData.forEach((level, index) => {
                    const videoInput = $(`#level-video-${index + 1}`)[0]; // Video del nivel
                    const fileInput = $(`#level-file-${index + 1}`)[0];   // Archivo opcional del nivel
            
                    formData.append(`levels[${index}][title]`, level.title);
                    formData.append(`levels[${index}][description]`, level.description);
                    formData.append(`levels[${index}][price]`, level.price);
            
                    // Verificar si se seleccionó un video para este nivel
                    if (videoInput.files.length > 0) {
                        formData.append(`levels[${index}][video]`, videoInput.files[0]);
                    } else {
                        console.warn(`No se seleccionó un video para el nivel ${index + 1}`);
                    }
            
                    // Verificar si se seleccionó un archivo para este nivel
                    if (fileInput.files.length > 0) {
                        formData.append(`levels[${index}][file]`, fileInput.files[0]);
                    } else {
                        console.log(`No se seleccionó un archivo opcional para el nivel ${index + 1}`);
                    }
                });
            
                // Agregar la opción para crear el curso
                formData.append('option', 'createCourse');
            
                // Imprimir los datos en consola antes de enviar
                console.log("Datos del curso enviados:", formData);
            
                // Enviar los datos con AJAX usando FormData
                $.ajax({
                    type: "POST",
                    url: "../../api/courseController.php",
                    data: formData,
                    processData: false,  // No procesar los datos
                    contentType: false,  // No establecer el tipo de contenido
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            alert('¡Curso creado con éxito!');
            
                            // Limpiar todos los campos después de guardar el curso
                            $("#course-title").val('');
                            $("#course-desc").val('');
                            $("#course-img").val('');
                            $("#course-price").val('');
                            $("#course-category").val('');
                            $("#level-count").val('0');
                            $("#addlevel").empty();
                        } else {
                            alert('Error al crear el curso.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud:', error);
                        var errorResponse = JSON.parse(xhr.responseText);
                        alert('Error en la solicitud: ' + errorResponse.message);
                    }
                });
            }
            
        }
    });
    
    
});
