$(document ).ready(function() {
    console.log('ola');
    $("#addlevel").slideToggle();
    $("#show-form").click(function(){
        $("#addlevel").slideToggle("slow");
    });
    
    $("#addNNewLevel").click(function(){
        alert('Por favor llene todos los campos');
    });
});