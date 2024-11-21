// search.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('searchBarContainer');
    const searchInput = document.getElementById('search-input');
    const numberOfCategories = document.getElementById('category-select');
    const dateStart = document.getElementById('date-start');
    const dateEnd = document.getElementById('date-end');
    const search = document.getElementById('search-query');
    const results = document.getElementById('results');

    // Mostrar estrellas basadas en el promedio del curso
    const starsContainer = document.querySelector('.rate-stars');  // Contenedor donde colocarás las estrellas
    starsContainer.innerHTML = '';  // Limpiar el contenedor de estrellas


    //const numberOfCategories = document.getElementById('number-of-categories');

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

    const query = searchInput.value.trim();
    const category = numberOfCategories.value;
    const startDate = dateStart.value;
    const endDate = dateEnd.value;

    const params1 = new URLSearchParams({
        option: 'searchCourses',
        query,
        category,
        startDate,
        endDate
    });

    $.ajax({
        type: "GET",
        url: "../../api/courseController.php?" + params1.toString(),
        dataType: "json",
        success: function (response) {
            if (response.success) {
                results.textContent = "Resultados de búsqueda para: " + "''" + query + "''";
                renderCourses(response.courses); // Renderiza los resultados
            } else {
                alert(response.message || 'No se encontraron resultados');
                results.textContent = "No se encontraron resultados para: " + "''" + query + "''";
                renderCourses(response.courses);
                
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });


    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const query = searchInput.value.trim();
        const category = numberOfCategories.value;
        const startDate = dateStart.value;
        const endDate = dateEnd.value;

        search.textContent = query;

        const params = new URLSearchParams({
            option: 'searchCourses',
            query,
            category,
            startDate,
            endDate
        });

        $.ajax({
            type: "GET",
            url: "../../api/courseController.php?" + params.toString(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    results.textContent = "Resultados de búsqueda para: " + "''" + query + "''";
                    renderCourses(response.courses); // Renderiza los resultados
                } else {
                    alert(response.message || 'No se encontraron resultados');
                    results.textContent = "No se encontraron resultados para: " + "''" + query + "''";
                    renderCourses(response.courses);
                    
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
            }
        });
    });

    function renderCourses(courses) {
        const resultsContainer = document.querySelector('.results-container');
        resultsContainer.innerHTML = ''; // Limpia los resultados previos

        courses.forEach(course => {
            const courseDiv = document.createElement('div');
            courseDiv.classList.add('course');
            courseDiv.innerHTML = `
                <img src="../${course.Curso_Imagen}" alt="${course.Curso_Titulo}">
                <h5 class="title baby">${course.Curso_Titulo}</h5>
                <p class="detail eerie">${course.Instructor_Nombre}</p>
                <p style="color #003054; font-size:20px;">${course.Curso_Descripcion}</p>
                <div class="rate-stars">
                    <h5 class="tiny-name baby">Valoración:</h5>
                    ${generateStars(course.Promedio_Calificacion)}
                </div>
                <br>
                <h4 class="name yellow">$${course.Curso_Precio}</h4>
                
            `;
            resultsContainer.appendChild(courseDiv);
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

    
});