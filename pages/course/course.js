// Añadir curso al carrito
document.querySelector('.agregar-carrito').addEventListener('click', function() {
    alert("Curso agregado al carrito");
});

// Añadir nivel al carrito
const levelButtons = document.querySelectorAll('.boton-compra');
levelButtons.forEach(button => {
    button.addEventListener('click', function() {
        alert("Nivel añadido al carrito");
    });
});

// Publicar comentario y/o calificación
document.getElementById('submitComment').addEventListener('click', function() {
    const comment = document.getElementById('comment').value;
    const rating = document.getElementById('rating').value;
    const commentsContainer = document.querySelector('.comments-container');

    // Validación: debe haber al menos un comentario o calificación
    if (!comment && (rating === "6")) {
        alert("Por favor, escribe un comentario o elige una calificación.");
        return;
    }

    // Crear el nuevo comentario para publicarlo
    const newComment = document.createElement('div');
    newComment.classList.add('comment');

    // Contenedor de textos (nombre, estrellas, comentario)
    const textsContainer = document.createElement('div');
    textsContainer.classList.add('texts-container');

    // Calificación (si la hay)
    if (rating !== "6") {
        const starsContainer = document.createElement('div');
        starsContainer.classList.add('name-and-stars');

        // Añadir nombre del usuario (puedes cambiar "Nuevo Usuario" a un nombre dinámico si lo deseas)
        const userName = document.createElement('h5');
        userName.classList.add('name');
        userName.textContent = "Nuevo Usuario";
        starsContainer.appendChild(userName);

        // Crear las estrellas dinámicamente según la calificación
        for (let i = 0; i < rating; i++) {
            const star = document.createElement('img');
            star.src = '../resources/star.png'; // Usar la imagen de la estrella
            star.alt = `${i + 1} estrellas`;
            starsContainer.appendChild(star);
        }

        textsContainer.appendChild(starsContainer);
    }

    // Texto del comentario
    const commentText = document.createElement('p');
    commentText.classList.add('description');
    commentText.textContent = comment || "Sin comentario.";
    textsContainer.appendChild(commentText);

    // Añadir textsContainer al nuevo comentario
    newComment.appendChild(textsContainer);

    // Añadir el nuevo comentario al contenedor de comentarios
    commentsContainer.appendChild(newComment);

    // Limpiar los campos del formulario
    document.getElementById('comment').value = "";
    document.getElementById('rating').value = "6";
});

function openReportMenu(button) {
    const reportMenu = button.parentElement.nextElementSibling;
    reportMenu.style.display = 'block';
}

function closeReportMenu(button) {
    const reportMenu = button.parentElement;
    reportMenu.style.display = 'none';
}

function submitReport(button) {
    const reportMenu = button.parentElement;
    const selectedReason = reportMenu.querySelector('input[name="reportReason"]:checked');
    
    if (selectedReason) {
        alert(`Comentario reportado por: ${selectedReason.value}`);
        // Aquí podrías enviar el motivo de reporte al servidor usando una solicitud AJAX o similar
        closeReportMenu(button);
    } else {
        alert('Por favor, selecciona un motivo');
    }
}


