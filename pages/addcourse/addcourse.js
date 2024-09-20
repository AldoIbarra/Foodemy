$(document ).ready(function() {
    $("#addlevel").slideToggle();
    $("#show-form").click(function(){
        $("#addlevel").slideToggle("slow");
    });
    
    $("#addNNewLevel").click(function(){
    });
});

$("#save-course").click(function(){
    if($("#course-title").val() == '' || $("#course-desc").val() == '' || $("#course-img").val() == ''){
        alert('Falta algunos de los datos del curso');
    }else if($("#level-title").val() == '' || $("#level-desc").val() == '' || $("#level-price").val() == '' || $("#level-video").val() == ''){
        alert('Falta algunos de los datos del nivel');
    }else{
        alert('Curso agregado correctamente');
    }
});

$("#addNNewLevel").click(function(){
    if($("#level-title").val() == '' || $("#level-desc").val() == '' || $("#level-price").val() == '' || $("#level-video").val() == ''){
        alert('Falta algunos de los datos del nivel');
    }else{
        alert('Nivel agregado correctamente');
    }
});