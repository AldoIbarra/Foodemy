
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




document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formulariosp').addEventListener('submit', function(event) {
        // Previene el envío del formulario si hay errores
        event.preventDefault();

        // Obtiene los valores de los campos
        const nombre = document.getElementById('nombre')?.value.trim() || '';
        const apellido = document.getElementById('apellido')?.value.trim() || '';
        const cvv = document.getElementById('cvv')?.value.trim() || '';
        const tarjeta = document.getElementById('tarjeta')?.value || '';
        const fechaN = document.getElementById('fecha')?.value || '';
       
        let TODOcorrecto = 5;


        // 1. Valida el campo de nombre
        if (nombre === '') {
            TODOcorrecto -= 1;
            alert('Ingresar un nombre válido');
        }

        // 2. Valida el campo de apellido
        if (apellido === '') {
            TODOcorrecto -= 1;
            alert('Ingresar un apellido válido');
        }

        // 3. Valida el campo de tajeta
        if (tarjeta === '') {
            TODOcorrecto -= 1;
            alert('Falta número de tarjeta');
        } else if (!/^\d+$/.test(cvv)) {
            TODOcorrecto -= 1;
            alert('Tarjeta debe solo contener números.');
        }

        // 4. Valida el campo de cvv
        if (cvv === '') {
            TODOcorrecto -= 1;
            alert('Falta CVV');
        } else if (cvv.length != 3) {
            TODOcorrecto -= 1;
            alert('CVV solo acepta 3 números.');  
        } else if (!/^\d+$/.test(cvv)) {
            TODOcorrecto -= 1;
            alert('CVV debe solo contener números.');
        }

        // 5. Valida el campo de fecha

        if (fechaN === '') {
            TODOcorrecto -= 1;
            alert('Seleccionar una fecha de vencimiento');
        }
        

        // Si todo es válido, envía el formulario
        if (TODOcorrecto === 5) {
            alert(`Espere mientras se procesa el pago.`);
            // Descomenta esto para enviar el formulario realmente
        } else {
            alert('Error al procesar su solicitud');
        }
    });
});
