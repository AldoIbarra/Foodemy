document.addEventListener("DOMContentLoaded", () => {
    const unlockSection = document.querySelector("#unlockSection .row");

    // Función para cargar usuarios
    const loadUsers = () => {
        const params = new URLSearchParams({
            option: 'getAllUsersExcept'
        });

        $.ajax({
            type: "GET",
            url: "../../api/usersController.php?" + params.toString(),
            dataType: "json",
            success: function (response) {
                console.log("Respuesta completa del servidor:", response); // Ver la respuesta completa
                if (response.success) {
                    renderUsers(response.Usuarios);
                } else {
                    console.error('Error al cargar los usuarios:', response.message || 'Respuesta mal formada');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
                try {
                    console.log("Respuesta del servidor:", xhr.responseText); // Ver la respuesta completa
                } catch (e) {
                    console.error("No se pudo parsear la respuesta del servidor:", e);
                }
            }
        });
    };

    // Función para renderizar usuarios
    const renderUsers = (users) => {
        unlockSection.innerHTML = ""; // Limpiar contenido previo

        users.forEach(user => {
            const userBlock = document.createElement("div");
            userBlock.classList.add("col-4", "user-blocked");

            userBlock.innerHTML = `
    <img src="data:image/jpeg;base64,${user.Foto_Perfil}" alt="${user.Nombre_Completo}" class="profile-pic">
    <h5 class="tiny-name baby">${user.Nombre_Completo}</h5>
    <p class="detail baby">${user.Estatus == 1 ? user.reason || "Usuario Desbloqueado" : user.reason || "Usuario Bloqueado"}</p>
    <button class="unlock-button">Desbloquear</button>
`;

            // Agregar evento para desbloquear
            userBlock.querySelector(".unlock-button").addEventListener("click", () => {
                alert(`El usuario ${user.Nombre_Completo} ha sido desbloqueado.`);
                userBlock.remove(); // Eliminar visualmente
            });

            unlockSection.appendChild(userBlock);
        });
    };

    // Llamar a loadUsers al inicio
    loadUsers();
});
