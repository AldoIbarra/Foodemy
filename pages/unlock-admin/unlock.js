document.addEventListener("DOMContentLoaded", () => {
    const unlockSection = document.querySelector("#unlockSection .row");

    const loadUsers = () => {
        const params = new URLSearchParams({
            option: 'getAllUsersExcept'
        });

        $.ajax({
            type: "GET",
            url: "../../api/usersController.php?" + params.toString(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    renderUsers(response.Usuarios);
                } else {
                    console.error('Error al cargar los usuarios:', response.message || 'Respuesta mal formada');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
            }
        });
    };

    const renderUsers = (users) => {
        unlockSection.innerHTML = "";

        users.forEach(user => {
            const userBlock = document.createElement("div");
            userBlock.classList.add("col-4", "user-blocked");

            userBlock.innerHTML = `
                <img src="data:image/jpeg;base64,${user.Foto_Perfil}" alt="${user.Nombre_Completo}" class="profile-pic">
                <h5 class="tiny-name baby">${user.Nombre_Completo}</h5>
                <p class="detail baby">${user.Estatus == 1 ? "Usuario Desbloqueado" : "Usuario Bloqueado"}</p>
                <button class=${user.Estatus == 1 ? "block-button" : "unlock-button"}>${user.Estatus == 1 ? "Bloquear" : "Desbloquear"}</button>
            `;

            // Agregar evento para bloquear/desbloquear
            userBlock.querySelector("button").addEventListener("click", () => {
                const action = user.Estatus == 1 ? "bloquear" : "desbloquear";
                const confirmation = confirm(`¿Estás seguro de que deseas ${action} al usuario "${user.Nombre_Completo}"?`);

                if (confirmation) {
                    updateUserStatus(user.ID_Usuario, userBlock);
                }
            });

            unlockSection.appendChild(userBlock);
        });
    };

    // Función para actualizar el estado del usuario
    const updateUserStatus = (id_usuario, userBlock) => {
        $.ajax({
            type: "POST",
            url: "../../api/usersController.php",
            data: {
                option: 'blockUser',
                id_usuario: id_usuario
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("El estado del usuario se actualizó correctamente.");
                    loadUsers(); // Recargar la lista de usuarios
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("Error en la solicitud. Por favor, intenta de nuevo.");
                console.error("Error:", error);
            }
        });
    };

    loadUsers();
});
