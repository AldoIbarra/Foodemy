document.addEventListener("DOMContentLoaded", function () {
    const coursesContainer = document.querySelector('#myCoursesSection .container .row');  // Seleccionar la fila dentro del contenedor

    // Hacer la solicitud AJAX para obtener los cursos
    const params = new URLSearchParams({ option: 'getCoursesById' });
    $.ajax({
        type: "GET",
        url: "../../api/courseController.php?" + params.toString(),
        dataType: "json",
        success: function (response) {
            if (response.success && Array.isArray(response.courses)) {
                // Asegurarse de que 'courses' esté disponible y sea un array
                response.courses.forEach(course => addCourseToPage(course));
            } else {
                console.error('Error al cargar los cursos:', response.error || 'Respuesta mal formada');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });

    // Función para agregar los cursos a la página
    function addCourseToPage(course) {
        const courseHTML = `
            <div class="col-4 course" data-id="${course.ID_Curso}">
                <img src="../${course.Curso_Imagen}" alt="Imagen del curso" class="course img">
                <h5 class="tiny-name baby">${course.Curso_Titulo}</h5>
                <p class="detail baby">${course.Total_Ventas} estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración:</h5>
                    ${generateStars(course.Promedio_Calificacion)}
                </div>
                <button class="blue-button" onclick="window.location.href='detallecurso.php?id=${course.ID_Curso}';">Ver detalles</button>
                <button class="red-button" onclick="deleteCourse(${course.ID_Curso});">Eliminar curso</button>
            </div>
        `;
        coursesContainer.insertAdjacentHTML('beforeend', courseHTML);
    }
    

    // Función para generar las estrellas de valoración
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

});


// Función para eliminar curso (como ejemplo)
function deleteCourse(courseId) {
    if (confirm('¿Estás seguro de que deseas eliminar este curso?')) {
        $.ajax({
            type: "POST",
            url: "../../api/courseController.php",
            data: { option: 'deleteCourse', id_course: courseId },
            success: function (response) {
                if (response.success) {
                    alert('Curso eliminado con éxito.');
                    $(`.course[data-id="${courseId}"]`).remove(); // Selecciona y elimina el curso por su ID
                } else {
                    alert('Error al eliminar el curso.');
                }
            },
            error: function (xhr, status, error) {
                alert('Hubo un problema al intentar eliminar el curso. Intenta nuevamente.');
                console.error('Error en la solicitud:', error);
            }
        });
    }
}
