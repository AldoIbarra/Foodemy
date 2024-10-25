const inputs= document.querySelectorAll('.input');
var nombre;
var sexo;
var fechaN;
var session;
var id;

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

const inputFoto = document.getElementById('inputFoto');
const imagenPrevisualizada = document.getElementById('imagenPrevisualizada');

// Agregar un evento cuando se seleccione un archivo
inputFoto.addEventListener('change', function(event) {
    const archivo = event.target.files[0];  // Obtener el archivo seleccionado

    if (archivo) {
        // Crear un objeto FileReader para leer el archivo
        const reader = new FileReader();

        reader.onload = function(e) {
            // Establecer la imagen previsualizada con la URL generada
            imagenPrevisualizada.src = e.target.result;
        }

        // Leer el archivo como una URL
        reader.readAsDataURL(archivo);
    } else {
        // Limpiar la imagen si no hay archivo seleccionado
        imagenPrevisualizada.src = '../resources/logoCursosCocina.jpg';
    }
});



document.addEventListener('DOMContentLoaded', function() {
    event.preventDefault();
    document.getElementById('formulariosp').addEventListener('submit', function(event) {
        // Previene el envío del formulario si hay errores
        event.preventDefault();

        // Obtiene los valores de los campos
        nombre = document.getElementById('nombre')?.value.trim() || '';
        sexo = document.getElementById('sexo')?.value || '';
        fechaN = document.getElementById('fecha')?.value || '';
        id = document.getElementById('id')?.value.trim() || '';
       
        let TODOcorrecto = 3;

        // 1. Valida el campo de nombre
        if (nombre === '') {
            TODOcorrecto -= 1;
            alert('Ingresar un nombre válido');
        }

        // 2. Valida el campo de sexo
        if (sexo === '') {
            TODOcorrecto -= 1;
            alert('Seleccionar un sexo');
        }

        // 3. Valida el campo de fecha

        const fechaC = new Date(fechaN);
        const fechaMin = new Date('1900-01-01');
        const fechaMax = new Date('2009-12-31');

        if (fechaC === '') {
            TODOcorrecto -= 1;
            alert('Seleccionar una fecha y hora');
        }else if (fechaC < fechaMin || fechaC > fechaMax) {
            TODOcorrecto -= 1;
            alert('La fecha debe estar entre el 1 de enero de 1930 y el 31 de diciembre de 2009.');
        }
        

        // Si todo es válido, envía el formulario
        if (TODOcorrecto === 3) {
            event.preventDefault();
            alert(nombre + sexo + fechaN + id);
            updateInfo();
        } else {
            alert('Datos incorrectos');
        }
    });
});

function updateInfo(){
    $.ajax({
        type: "POST",
        url: "../../api/usersController.php",
        data: {
            name: nombre,
            gender: sexo,
            bornDate: fechaN,
            id: id,
            option: 'updateInfo'
        },
        success: function(data) {
            //location.reload();
            window.location.replace("profile.php");
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.log('error');
            console.log(error);
        },
    });
}