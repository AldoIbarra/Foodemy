var session;
var courseId;
var cursoComprado = false;
var cursoTerminado = false;
var courseGlobalinfo;
const urlParams = new URLSearchParams(window.location.search);
$( document ).ready(function() {
    $.ajaxSetup({cache: false})
    $.get('../../api/getSession.php', function (data) {
        if(data){
            session = JSON.parse(data);
            console.log(session);
            console.log(session.Rol);
            if(session.Rol == "Estudiante"){
                courseId = urlParams.get('id');
                setBuyButton(courseId);
            }
        }else{
            console.error("Error al analizar JSON");
        }
    });
});

// Esperar a que el documento esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Obtener el ID del curso desde la URL
    const courseId = urlParams.get('id');
    if (!courseId || isNaN(courseId)) {
        console.error('ID de curso no válido');
        window.location.href = 'http://localhost/foodemy/pages/dashboard/dashboard.php';
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
                courseGlobalinfo = response.course;
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

function setBuyButton(thisCourseId){
    $.ajax({
        type: "GET",
        url: "../../api/courseController.php?",
        data: {
            option: "doesStudentHaveCourse",
            courseId: thisCourseId
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if(!response.result.comprado){
                $('.price-and-button').append('<a href="../shoppingcart/shoppingcart.php?id=' + courseId + '" class="red-button">Comprar</a>');
                $('#markAsEndedContainer').empty();
            }else{
                cursoComprado = true;
                $('#comment-button').prop("disabled", false);
            }
            if(response.result.terminado){
                $('#markAsEndedContainer').empty();
                $('#markAsEndedContainer').append('<button class="red-button" onclick="generarCertificado();">¡Obtener Certificado!</button>');
                cursoTerminado = true;
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function comment(){
    if(!cursoComprado){
        alert('Solo puedes comentar si has comprado el curso');
        return;
    }
    if(!cursoTerminado){
        alert('Tienes que terminar el curso para comentar y calificar');
        return;
    }
    var stars = $('#rank-stars').find(":selected").val();
    if(!$('#comment-text').val() == ''){
        formData = new FormData();

        formData.append('courseId', courseId);
        formData.append('userId', session.ID_Usuario);
        formData.append('comment', $('#comment-text').val());
        formData.append('rank', stars);
        formData.append('option', 'makeAComment');

        $.ajax({
            type: "POST",
            url: "../../api/courseController.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log('error');
                console.log(error);
            },
        });
    }
}

function markCourse(){
    
    formData = new FormData();
    formData.append('option', 'markCourse');
    formData.append('courseId', courseId);
    formData.append('UserId', session.ID_Usuario);

    $.ajax({
        type: "POST",
        url: "../../api/courseController.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            console.log(data);
            alert('¡Curso terminado!, ¡Felicidades!');
            location.reload();
        },
        error: function(xhr, status, error) {
            console.log('error');
            console.log(error);
        },
    });
}

function generarCertificado(nombreEstudiante, nombreCurso, nombreInstructor, fechaFinalizacion) {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    
    today = dd + '/' + mm + '/' + yyyy;

    console.log(courseGlobalinfo);
    nombreEstudiante = session.Nombre_Completo;
    nombreCurso = courseGlobalinfo.Curso_Titulo;
    nombreInstructor = courseGlobalinfo.Instructor_Nombre;
    fechaFinalizacion = today;
    const certificadoHTML = `
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap');
            body {
                background-color: #003054;
                color: #fff;
                font-family: 'Outfit', sans-serif;
            }
            h2.nombre-estudiante {
                font-family: 'Dancing Script', cursive;
                font-size: 60px;
                color: #efb810;
                margin-bottom: 5px;
            }
            .nombre-estudiante-línea {
                border-bottom: 2px solid #E32D40;
                width: 60%;
                margin: 0 auto 20px auto;
            }
            .certificado-container {
                border: 5px solid #efb810;
                padding: 20px;
                max-width: 800px;
                margin: auto;
                position: relative;
                background: #fff;
                font-family: 'Outfit', sans-serif;
                border-radius: 10px;
                text-align: center;
                background-image: url('https://img.freepik.com/vector-premium/diseno-plantilla-degradado-onda-fondo-linea_483537-5070.jpg');
                background-size: cover;
                background-position: center;
            }
            .certificado-container p {
                color: #202020;
            }
            .certificado-container h1,
            .certificado-container h2 {
                color: #202020;
            }
            .firma-director {
                width: 150px;
                margin: 0 auto;
                margin-top: -95px;
            }
            .descargar-pdf {
                margin-top: 20px;
            }
        </style>
        <div class="certificado-container">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <img src="https://cdn-icons-png.flaticon.com/512/214/214282.png" alt="Logo Izquierda" style="max-width: 100px; max-height: 100px; border-radius: 10px;">
                <div style="border-bottom: 3px solid #efb810; padding-bottom: 10px; width: 100%; text-align: center;">
                    <h1 style="color: #efb810; font-size: 36px;">Certificado de Finalización</h1>
                </div>
                <img src="../resources/logoCurso.png" alt="Logo Derecha" style="max-width: 100px; max-height: 100px; border-radius: 10px;">
            </div>
            <p style="font-size: 20px; margin-bottom: 10px; margin-top: 80px; color: #202020;">OTORGADO A:</p>
            <h2 class="nombre-estudiante" style="color: #efb810;">${nombreEstudiante}</h2>
            <div class="nombre-estudiante-línea" style="border-bottom: 2px solid #003054;"></div>
            <p style="font-size: 20px; margin-bottom: 10px; color: #202020;">Por haber completado satisfactoriamente el curso virtual de</p>
            <h2 style="display: inline-block; margin-bottom: 20px; font-size: 24px; color: #003054;">${nombreCurso}</h2>
            <p style="font-size: 20px; margin-bottom: 10px; color: #202020;">en la fecha</p>
            <h2 style="display: inline-block; margin-bottom: 20px; font-size: 24px; color: #003054;">${fechaFinalizacion}</h2>
            <p style="font-size: 20px; margin-bottom: 10px; color: #202020;">Impartido a través de la página oficial de Foodemy</p>
            <p style="font-size: 20px; margin-bottom: 10px; margin-top: 50px; color: #202020;">Instructor:</p>
            <h2 style="display: inline-block; margin-bottom: 40px; font-size: 24px; color: #003054;">${nombreInstructor}</h2>
            <div style="border-top: 2px solid #efb810; width: 200px; margin: 20px auto; margin-top: 60px; height: 30px;"></div>
            <img class="firma-director" src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Jon_Kirsch%27s_Signature.png" alt="Firma del Director">
            <p style="font-size: 18px; color: #efb810; margin-top: -35px;">Firma del Director:</p>
            <button class="descargar-pdf" onclick="descargarPDF()">Descargar PDF</button>
        </div>

    `;

    // Mostrar el certificado en una nueva ventana
    const ventanaCertificado = window.open('', '_blank');
    ventanaCertificado.document.open();
    ventanaCertificado.document.write(certificadoHTML);
    ventanaCertificado.document.close();

    ventanaCertificado.onload = function() {
        ventanaCertificado.document.querySelector('.descargar-pdf').addEventListener('click', function() {
            // Crear el PDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Añadir contenido al PDF
            doc.setFont('Outfit', 'bold');
            doc.setFontSize(22);
            doc.text('Certificado de Finalización', 105, 20, { align: 'center' });
            
            doc.setFontSize(16);
            doc.setFont('Outfit', 'regular');
            doc.text(`OTORGADO A: ${nombreEstudiante}`, 105, 40, { align: 'center' });
            doc.text(`Por haber completado satisfactoriamente el curso virtual de ${nombreCurso}`, 105, 60, { align: 'center' });
            doc.text(`en la fecha ${fechaFinalizacion}`, 105, 80, { align: 'center' });
            doc.text(`Impartido a través de la página oficial de Foodemy`, 105, 100, { align: 'center' });
            doc.text(`Instructor: ${nombreInstructor}`, 105, 120, { align: 'center' });
            
            // Añadir la firma y línea de firma
            doc.setFont('Outfit', 'bold');
            doc.text('Firma del Director:', 105, 160, { align: 'center' });
            doc.line(30, 165, 180, 165); // Línea para la firma
            
            // Guardar el PDF
            doc.save('certificado.pdf');
        });
    };
}