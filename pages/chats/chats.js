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
    if(!selectedUserId){
        $("#sendMsgBtn").prop("disabled", true);
        $("#messageContainer").prop("disabled", true);
    }
    $("#messageContainer").on("input", function() {
        if ($("#messageContainer").val().trim() !== "") {
            $("#sendMsgBtn").prop("disabled", false);
        } else {
            $("#sendMsgBtn").prop("disabled", true);
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
        var chat = '<button onclick="setChatId(' + user.ID_Instructor + ');" class="contact baby"><img src="data:image/jpeg;base64,' + user.Foto_Instructor +'" alt=""><h4>' + user.Nombre_Instructor + '</h4></button><hr>';
        $('#contact-list').append(chat);
    });
}

function setTeacherChats(users){
    users.forEach(user => {
        var chat = '<button onclick="setChatId(' + user.ID_Estudiante + ');" class="contact baby"><img src="data:image/jpeg;base64,' + user.Foto_Estudiante +'" alt=""><h4>' + user.Nombre_Estudiante + '</h4></button><hr>';
        $('#contact-list').append(chat);
    });
}

function setChatId(userId){
    selectedUserId = userId;
    //getChat();
    setInterval(getChat, 2000);
}

function getChat(){
    console.log('cargo');
    $("#messageContainer").prop("disabled", false);
    const found = users.find((element) => element.ID_Estudiante == selectedUserId || element.ID_Instructor == selectedUserId);
    if(found.ID_Estudiante == selectedUserId){
        document.getElementById("chatimg").src = 'data:image/jpeg;base64,' + found.Foto_Estudiante;
        $('#chatName').text(found.Nombre_Estudiante);
    }else if(found.ID_Instructor == selectedUserId){
        document.getElementById("chatimg").src = 'data:image/jpeg;base64,' + found.Foto_Instructor;
        $('#chatName').text(found.Nombre_Instructor);
    }
    $.ajax({
        type: "GET",
        url: "../../api/usersController.php?",
        data: {
            option: "getMessagesBetweenUsers",
            user2Id: selectedUserId
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            fillChat(response.messages);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
        }
    });
}

function sendMsg(){
    var message = $('#messageContainer').val();
    $('#messageContainer').val('');

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

function fillChat(messages){
    var chatImg = $('#chatimg').attr("src");
    $(".messages").empty();
    messages.forEach(msg => {
        var message = '';
        if(session.ID_Usuario == msg.ID_Usuario_Emisor){
            //YO lo envie
            message = '<div class="message me"><p class="message-content">' + msg.Mensaje + '</p><img src="data:image/jpeg;base64,' + session.Foto_Perfil + '" alt=""></div>';
            $(".messages").append(message);
        }else{
            //Me lo enviaron
            message = '<div class="message you"><img src="' + chatImg + '" alt=""><p class="message-content">' + msg.Mensaje + '</p></div>';
            $(".messages").append(message);
        }
    });
}