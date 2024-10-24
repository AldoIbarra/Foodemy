const inputs= document.querySelectorAll('.input');
var correo;
var contra;
var session;

$( document ).ready(function() {
    $.ajaxSetup({cache: false})
    $.get('../../api/getSession.php', function (data) {
        console.log(data);
        if(data){
            session = JSON.parse(data);
            console.log(session);
        }else{
            console.error("Error al analizar JSON");
        }
    });
});

function focusFunc(){
    let parent= this.parentNode.parentNode;
    parent.classList.add('focus');
}

function blurFunc(){
    let parent= this.parentNode.parentNode;
    if(this.value ==""){
    parent.classList.remove('focus');
    }
}

inputs.forEach(input=>{
    input.addEventListener('focus',focusFunc);
    input.addEventListener('blur',blurFunc);
})



document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formulario').addEventListener('submit', function(event) {
        // Previene el envío del formulario si hay errores
        event.preventDefault();

        // Obtiene los valores de los campos
        correo = document.getElementById('correo')?.value.trim() || '';
        contra = document.getElementById('contra')?.value.trim() || '';

        let TODOcorrecto = 2;


        // 2. Valida el campo de correo
        if (correo === '') {
            TODOcorrecto -= 1;
            alert('Ingresar un correo');
        } else if (!/\S+@\S+\.\S+/.test(correo)) {
            TODOcorrecto -= 1;
            alert('Ingresar un correo válido');
        }

        // 3. Valida el campo de contraseña
        if (contra === '') {
            TODOcorrecto -= 1;
            alert('Ingresar una contraseña');
        } else if (contra.length < 8) {
            TODOcorrecto -= 1;
            alert('La contraseña debe tener al menos 8 caracteres.');
        } else if (!/[a-zA-Z]/.test(contra)) {
            TODOcorrecto -= 1;
            alert('La contraseña debe contener al menos una letra.');
        } else if (!/\d/.test(contra)) {
            TODOcorrecto -= 1;
            alert('La contraseña debe contener al menos un número.');
        }

        // Si todo es válido, envía el formulario
        if (TODOcorrecto === 2) {
            login();
             // Descomenta esto para enviar el formulario realmente
        } else {
            alert('Datos incorrectos');
        }
    });
});

function login() {
    $.ajax({
        type: "POST",
        url: "../../api/usersController.php",
        data: {
            email: correo,
            password: contra,
            option: 'logIn'
        },
        success: function(data) {
            location.reload();
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.log('error');
            console.log(error);
        },
    });
}
