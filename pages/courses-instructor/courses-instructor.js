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
            <div class="col-4 course">
                <img src="../${course.Curso_Imagen}" alt="Imagen del curso" class="course img">
                <h5 class="tiny-name baby">${course.Curso_Titulo}</h5>
                <p class="detail baby">${course.Total_Students} estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración:</h5>
                    ${generateStars(course.Promedio_Calificacion)}
                </div>
                <button class="blue-button" onclick="window.location.href='detallecurso.php?id=${course.ID_Curso}';">Ver detalles</button>
                <button class="red-button" onclick="deleteCourse(${course.ID_Curso});">Eliminar curso</button>
            </div>
        `;
        coursesContainer.insertAdjacentHTML('beforeend', courseHTML);  // Insertar el nuevo curso en la fila
    }

    // Función para generar las estrellas de valoración
    function generateStars(rating) {
        let starsHTML = '';
        for (let i = 0; i < 5; i++) {
            if (i < rating) {
                starsHTML += '<img src="../resources/star.svg" alt="Estrella">';
            } else if (i === Math.floor(rating) && rating % 1 !== 0) {
                starsHTML += '<img src="../resources/half-star.svg" alt="Media estrella">';
            } else {
                starsHTML += '<img src="../resources/star-empty.svg" alt="Estrella vacía">';
            }
        }
        return starsHTML;
    }

    // Función para eliminar curso (como ejemplo)
    function deleteCourse(courseId) {
        if (confirm('¿Estás seguro de que deseas eliminar este curso?')) {
            // Aquí puedes agregar lógica para eliminar el curso
            console.log('Eliminando curso con ID:', courseId);
        }
    }
});
