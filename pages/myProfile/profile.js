var session;
$( document ).ready(function() {
    $.ajaxSetup({cache: false})
    $.get('../../api/getSession.php', function (data) {
        if(data){
            session = JSON.parse(data);
            console.log(session);
            setProfileValues();
        }else{
            console.error("Error al analizar JSON");
        }
    });
});

function setProfileValues(){
    $('#userName').append(session.Nombre_Completo);
    $('#userType').append(session.Rol);
    $('#birthDate').append(session.Fecha_Nacimiento);
    $('#gender').append(session.Genero);
    document.getElementById("userImg").src = 'data:image/jpeg;base64,' + session.Foto_Perfil;
}