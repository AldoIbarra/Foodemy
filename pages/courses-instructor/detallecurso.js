// Esperar a que el documento esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Obtener el ID del curso desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const courseId = urlParams.get('id');
    if (!courseId || isNaN(courseId)) {
        console.error('ID de curso no válido');
        return;
    }
    console.log(window.location.search);
    
    if (courseId) {
        // Hacer la solicitud AJAX para obtener la información del curso
        fetchCourseInfo(courseId);
    } else {
        console.error("No course ID found in the URL.");
    }
});

function fetchCourseInfo(courseId) {
    // Hacer la petición AJAX al servidor
    const params = new URLSearchParams({ option: 'getCourseById' });

    $.ajax({
        type: "POST",
        url: "../../api/courseController.php?" + params.toString(),
        dataType: "json",
        data: { id_curso: courseId }, // Pasamos el ID del curso como parámetro
        success: function(response) {
            console.log("Respuesta del servidor:", response);  // Imprime la respuesta directamente
            if (response.success && response.course) {
                updateCourseInfo(response.course);
            } else {
                console.error("Error: Curso no encontrado.");
            }
        }
    });
}

function updateCourseInfo(course) {
    // Actualizar el título del curso
    document.querySelector('.title.baby').textContent = course.Curso_Titulo;
    document.querySelector('.description.baby').textContent = course.Curso_Descripcion;
    document.querySelector('.option.mantis').textContent = course.Categoria_Titulo;
    document.querySelector('.detail.baby').textContent = course.Instructor_Nombre;
    document.querySelector('.price-and-button .title.baby').textContent = `$${course.Curso_Precio}`;

    // Actualizar la imagen del curso
    const imgElement = document.querySelector('.img-container img');
    imgElement.src = `../${course.Curso_Imagen}`;  // Esto funciona si es una ruta de archivo de imagen.

    // Mostrar estrellas basadas en el promedio del curso
    const starsContainer = document.querySelector('.rate-stars');  // Contenedor donde colocarás las estrellas
    starsContainer.innerHTML = '';  // Limpiar el contenedor de estrellas

    const averageRating = course.Promedio_Calificacion;

    // Actualizar el contador de niveles
    const levelsCountElement = document.querySelector('#levels-count');
    levelsCountElement.textContent = `${course.niveles.length} niveles`;

    // Generar las estrellas y agregarlas al contenedor
    starsContainer.innerHTML = generateStars(averageRating);

    // Actualizar los niveles
    const levelsContainer = document.querySelector('.levels');
    levelsContainer.innerHTML = ''; // Limpiar los niveles previos

    course.niveles.forEach(level => {
        const levelElement = document.createElement('div');
        levelElement.classList.add('level');
        levelElement.innerHTML = `
            <video controls>
                <source src="../${level.Nivel_Video}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div>
                <h4 class="name">${level.Nivel_Titulo}</h4>
                <h4 class="tiny-name">${level.Nivel_Descripcion}</h4>
            </div>
        `;

        // Verificar si hay archivos extras (propiedad `archivos`)
        if (level.archivos && level.archivos.length > 0) {
            const extrasSection = document.createElement('div');
            extrasSection.classList.add('extras-section');
            extrasSection.innerHTML = `
                <h5 class="extras-title">Archivos Extras</h5>
                <div class="extras-container">
                    ${level.archivos.map(file => `
                        <div class="extra-item">
                            <i class="fa fa-file-alt extra-icon" aria-hidden="true"></i>
                            <a href="../${file.Archivo_Ruta}" target="_blank" class="extra-link">
                                ${file.Archivo_Nombre || "Archivo Extra"}
                            </a>
                        </div>
                    `).join('')}
                </div>
            `;
            levelElement.appendChild(extrasSection);
        }
        

        levelsContainer.appendChild(levelElement);
    });

    // Actualizar los comentarios
    const commentsContainer = document.querySelector('.comments-container');
    commentsContainer.innerHTML = ''; // Limpiar los comentarios previos

    course.comentarios.forEach(comment => {
        const commentElement = document.createElement('div');
        commentElement.classList.add('comment');
        commentElement.innerHTML = `
            <img src="data:image/jpeg;base64,${comment.Usuario_Foto}" alt="${comment.Usuario_Nombre}"> <!-- Agregar prefijo base64 -->
            <div class="texts-container">
                <div class="name-and-stars">
                    <h5 class="name">${comment.Usuario_Nombre}</h5>
                    <!-- Mostrar las estrellas dadas por el usuario -->
                    <div class="user-rating">${generateStars(comment.Comentario_Calificacion)}</div>
                </div>
                <p class="description">${comment.Comentario_Texto}</p>
            </div>
        `;
        commentsContainer.appendChild(commentElement);
    });
}

function generateStars(rating) {
    let starsHTML = '';
    for (let i = 0; i < 5; i++) {
        if (i < Math.floor(rating)) {
            // Estrella completa
            starsHTML += '<i class="fa fa-star" aria-hidden="true"></i>';
        } else if (i === Math.floor(rating) && rating % 1 !== 0) {
            // Media estrella
            starsHTML += '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
        } else {
            // Estrella vacía
            starsHTML += '<i class="fa fa-star-o" aria-hidden="true"></i>';
        }
    }
    return starsHTML;
}
