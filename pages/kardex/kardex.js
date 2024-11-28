var session;
$( document ).ready(function() {
    $.ajaxSetup({cache: false})
    $.get('../../api/getSession.php', function (data) {
        if(data){
            session = JSON.parse(data);
            console.log(session);
            getCategories();
        }else{
            console.error("Error al analizar JSON");
        }
    });
});

function getCategories (){
    const params = new URLSearchParams({ option: 'getAllCategories' });
    $.ajax({
        type: "GET",
        url: "../../api/categoryController.php?" + params.toString(),
        dataType: "json",
        success: function (response) {
            if (response.success && Array.isArray(response.categories)) {
                console.log(response.categories);
                response.categories.forEach(element => {
                    var categoryElement = '<option value="' + element.ID_Categoria + '">' + element.Titulo + '</option>'
                    $('#number-of-categories').append(categoryElement);
                });
            } else {
                console.error('Error al cargar categorías:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function getStudentKardex(){
    var dateIni = $('#fecha-inscripcion-inicio').val();
    var dateFin = $('#fecha-inscripcion-fin').val();
    var categoryId = $('#number-of-categories').find(":selected").val();
    var courseStatus = $('#estado').find(":selected").val();
    var studentId = session.ID_Usuario;
    console.log(dateIni);
    console.log(dateFin);
    console.log(categoryId);
    console.log(courseStatus);
    $.ajax({
        type: "GET",
        url: "../../api/usersController.php?",
        data: {
            option: "getStudentKardex",
            dateIni: dateIni,
            dateFin: dateFin,
            categoryId: categoryId,
            courseStatus: courseStatus,
            studentId: studentId
        },
        dataType: "json",
        success: function (response) {
            console.log(response.courses);
            setCourses(response.courses);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function setCourses(courses){
    $(".kardex").empty();
    courses.forEach(course => {
        var fechaT = course.Fecha_Terminacion == null ? 'Sin terminar' : course.Fecha_Terminacion;
        var val = '<div class="course"><a  href="../courses-instructor/detallecurso.php?id=' + course.IdCurso + '"><h2>' + course.Curso + '</h2></a><div class="courseItem"><h4>Fecha de inscripción</h4><p id="inscriptionDate">' + course.Fecha_Inscripcion + '</p></div><div class="courseItem"><h4>Fecha de terminación</h4><p id="terminationDate">' + fechaT + '</p></div><div class="courseItem"><h4>Estado</h4><p id="statusInf">' + course.Estatus_Curso + '</p></div><div class="courseItem"><h4>Categoría</h4><p id="categoryInfo">' + course.Categoria + '</p></div></div>';
        $('.kardex').append(val);
    });
}