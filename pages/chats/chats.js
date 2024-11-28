var session;
var users;
var selectedUserId;
$( document ).ready(function() {
    $.ajaxSetup({cache: false})
    $.get('../../api/getSession.php', function (data) {
        if(data){
            session = JSON.parse(data);
            console.log(session);
            if(session.Rol == 'Estudiante'){
                getStudentChats();
            }else if(session.Rol == 'Instructor'){
                getTeacherChats();
            }
        }else{
            console.error("Error al analizar JSON");
        }
    });
});

function getStudentChats(){
    const params = new URLSearchParams({ option: 'getTeachersByStudentId' });
    $.ajax({
        type: "GET",
        url: "../../api/usersController.php?" + params.toString(),
        dataType: "json",
        success: function (response) {
            console.log(response.teachers);
            users = response.teachers;
            setStudentChats(users);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function getTeacherChats(){
    const params = new URLSearchParams({ option: 'getStudentsByTeacherId' });
    $.ajax({
        type: "GET",
        url: "../../api/usersController.php?" + params.toString(),
        dataType: "json",
        success: function (response) {
            console.log(response.students);
            users = response.students;
            setTeacherChats(users);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function setStudentChats(users){
    users.forEach(user => {
        var chat = '<button onclick="getChat(' + user.ID_Instructor + ');" class="contact baby"><img src="data:image/jpeg;base64,' + user.Foto_Instructor +'" alt=""><h4>' + user.Nombre_Instructor + '</h4></button><hr>';
        $('#contact-list').append(chat);
    });
}

function setTeacherChats(users){
    users.forEach(user => {
        var chat = '<button onclick="getChat(' + user.ID_Estudiante + ');" class="contact baby"><img src="data:image/jpeg;base64,' + user.Foto_Estudiante +'" alt=""><h4>' + user.Nombre_Estudiante + '</h4></button><hr>';
        $('#contact-list').append(chat);
    });
}

function getChat(userId){
    selectedUserId = userId;
    const found = users.find((element) => element.ID_Estudiante == userId || element.ID_Instructor == userId);
    if(found.ID_Estudiante == userId){
        document.getElementById("chatimg").src = 'data:image/jpeg;base64,' + found.Foto_Estudiante;
        $('#chatName').text(found.Nombre_Estudiante);
    }else if(found.ID_Instructor == userId){
        document.getElementById("chatimg").src = 'data:image/jpeg;base64,' + found.Foto_Instructor;
        $('#chatName').text(found.Nombre_Instructor);
    }
    $.ajax({
        type: "GET",
        url: "../../api/usersController.php?",
        data: {
            option: "getMessagesBetweenUsers",
            user2Id: userId
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function sendMsg(){
    var message = $('#messageContainer').val();
    $('#messageContainer').val('');
    console.log(message);

    formData = new FormData();

    formData.append('emmiter', session.ID_Usuario);
    formData.append('receiver', selectedUserId);
    formData.append('message', message);
    formData.append('option', 'sendMesage');

    $.ajax({
        type: "POST",
        url: "../../api/usersController.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.log('error');
            console.log(error);
        },
    });
}