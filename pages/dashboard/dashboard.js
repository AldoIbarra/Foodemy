var session;
$( document ).ready(function() {
    $.ajaxSetup({cache: false})
    $.get('../../api/getSession.php', function (data) {
        if(data){
            session = JSON.parse(data);
            console.log(session);
            getCourses();
        }else{
            console.error("Error al analizar JSON");
        }
    });
});

const params = new URLSearchParams({ option: 'getAllCourses' });

function getCourses(){
    $.ajax({
        type: "GET",
        url: "../../api/courseController.php?" + params.toString(),
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

function setCourses(values){
    values.forEach(element => {
        console.log(element);
        var button = '<a href="../courses-instructor/detallecurso.php?id=' + element.ID_Curso + '" class="col-3 course"><img src="../' + element.Imagen_Curso + '" alt=""><h5 class="tiny-name baby">' + element.Titulo + '</h5><p class="detail baby">' + element.Nombre_Completo + '</p><div><h5 class="tiny-name baby">2.5</h5><img src="../resources/star.svg" alt=""><img src="../resources/star.svg" alt=""><img src="../resources/half-star.svg" alt=""></div><h4 class="big-name baby">$' + element.Precio + '</h4></a>';
        $("#principal-courses").append(button);
    });
}