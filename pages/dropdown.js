$( document ).ready(function() {
    console.log('si entro');
    $(".user-menu").click(function() {
        $(this).toggleClass("show");
    });

    // var session;
    // $.ajaxSetup({cache: false})
    // $.get('../../api/getsession.php', function (data) {
    //     session = JSON.parse(data);
    //     console.log(session);
    //     $("#user_name").append(session.usuario_nombre.split(' ').slice(0,2).join(' '));
    // });
});