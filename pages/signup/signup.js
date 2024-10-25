const inputs= document.querySelectorAll('.input');
var nombre;
var correo;
var contra;
var sexo;
var fechaN; 
var inputFoto;
var usuarioTipo;
var formData;
var archivo;

$(document ).ready(function() {
    console.log('cargo');
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

inputFoto = document.getElementById('inputFoto');
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
    document.getElementById('formulariosp').addEventListener('submit', function(event) {
        // Previene el envío del formulario si hay errores
        event.preventDefault();

        // Obtiene los valores de los campos
        nombre = document.getElementById('nombre')?.value.trim() || '';
        correo = document.getElementById('correo')?.value.trim() || '';
        contra = document.getElementById('contra')?.value.trim() || '';
        sexo = document.getElementById('sexo')?.value || '';
        usuarioTipo = document.getElementById('usuarioTipo')?.value || '';
        fechaN = document.getElementById('fecha')?.value || '';
        inputFoto = document.getElementById('inputFoto')?.value || '';

        let TODOcorrecto = 7;

        //1. foto
        if (inputFoto === '') {
            TODOcorrecto -= 1;
            alert('Selecciona al menos una foto');
        }

        // 2. Valida el campo de nombre
        if (nombre === '') {
            TODOcorrecto -= 1;
            alert('Ingresar un nombre válido');
        }

        // 3. Valida el campo de correo
        if (correo === '') {
            TODOcorrecto -= 1;
            alert('Ingresar un correo');
        } else if (!/\S+@\S+\.\S+/.test(correo)) {
            TODOcorrecto -= 1;
            alert('Ingresar un correo válido');
        }

        // 4. Valida el campo de contraseña
        if (contra === '') {
            TODOcorrecto -= 1;
            alert('Ingresar una contraseña');
        } else if (contra.length < 8) {
            TODOcorrecto -= 1;
            alert('La contraseña debe tener al menos 8 caracteres.');
        } else if (!/[A-Z]/.test(contra)) {
            TODOcorrecto -= 1;
            alert('La contraseña debe contener al menos una letra mayúscula.');
        } else if (!/\d/.test(contra)) {
            TODOcorrecto -= 1;
            alert('La contraseña debe contener al menos un número.');
        } else if (!/[!@#$%^&*()]/.test(contra)) { 
            TODOcorrecto -= 1;
            alert('La contraseña debe contener al menos un carácter especial: !@#$%^&*() .');
        }

        // 5. Valida el campo de sexo
        if (sexo === '') {
            TODOcorrecto -= 1;
            alert('Seleccionar un sexo');
        }

        // 6. Valida el campo de fecha

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

        //7. Tipo de usuario
        
        if (usuarioTipo === '') {
            TODOcorrecto -= 1;
            alert('Seleccionar un tipo de usuario');
        }
        

        // Si todo es válido, envía el formulario
        if (TODOcorrecto === 7) {
            event.preventDefault();
            signup();
        } else {
            alert('Datos incorrectos');
        }
    });
});

function signup() {
    formData = new FormData();
    archivo = document.getElementById('inputFoto').files[0];
    if (archivo) {
        formData.append('imagen', archivo);
    }

    formData.append('name', nombre);
    formData.append('gender', sexo);
    formData.append('bornDate', fechaN);
    formData.append('email', correo);
    formData.append('password', contra);
    formData.append('userType', usuarioTipo);
    formData.append('option', 'signUp');

    $.ajax({
        type: "POST",
        url: "../../api/usersController.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            alert(`¡Usuario registrado con exito!`);
            window.location.replace("../login/login.php");
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.log('error');
            console.log(error);
        },
    });
}
