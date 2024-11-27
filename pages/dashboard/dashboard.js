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
            //setCourses(response);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function setCourses(values){
    values.courses.forEach(element => {
        console.log(element);
        // var option = '<img src="../' + element.Imagen + '" alt="">';
        // $('#dashboardSection').append(option);
    });
}