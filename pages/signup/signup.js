const inputs= document.querySelectorAll('.input');

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
    document.getElementById('formulariosp').addEventListener('submit', function(event) {
        // Previene el envío del formulario si hay errores
        event.preventDefault();

        // Obtiene los valores de los campos
        const nombre = document.getElementById('nombre')?.value.trim() || '';
        const correo = document.getElementById('correo')?.value.trim() || '';
        const contra = document.getElementById('contra')?.value.trim() || '';
        const sexo = document.getElementById('sexo')?.value || '';
        const fechaN = document.getElementById('fecha')?.value || '';
        const inputFoto = document.getElementById('inputFoto')?.value || '';

        let TODOcorrecto = 6;

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
        

        // Si todo es válido, envía el formulario
        if (TODOcorrecto === 6) {
            alert(`Formulario enviado correctamente!`);
            // Descomenta esto para enviar el formulario realmente
        } else {
            alert('Datos incorrectos');
        }
    });
});
