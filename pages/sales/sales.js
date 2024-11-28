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

function getSalesReport(){
    var dateIni = $('#fecha-inscripcion-inicio').val();
    var dateFin = $('#fecha-inscripcion-fin').val();
    var categoryId = $('#number-of-categories').find(":selected").val();
    var teacherId = session.ID_Usuario;
    console.log(dateIni);
    console.log(dateFin);
    console.log(categoryId);
    $.ajax({
        type: "GET",
        url: "../../api/usersController.php?",
        data: {
            option: "getSalesReport",
            dateIni: dateIni,
            dateFin: dateFin,
            categoryId: categoryId,
            teacherId: teacherId
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
    $('#tabla-ventas').empty();
    var tr= '<tr><th>Curso</th><th>Cantidad de alumnos inscritos</th><th>Total de ingresos</th></tr>';
    $('#tabla-ventas').append(tr);
    courses.forEach(course => {
        var td = '<tr><td>' + course.Nombre_Curso + '</td><td>' + course.Cantidad_Alumnos_Inscritos + '</td><td>' + course.Total_Ingresos + '</td></tr>';
        $('#tabla-ventas').append(td);
    });
}