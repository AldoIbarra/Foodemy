document.addEventListener("DOMContentLoaded", () => {
    const unlockButtons = document.querySelectorAll(".unlock-button");

    unlockButtons.forEach(button => {
        button.addEventListener("click", () => {
            const userBlock = button.closest(".user-blocked");
            const userName = userBlock.querySelector(".tiny-name").textContent;

            // Mostrar aviso de desbloqueo
            alert(`El usuario ${userName} ha sido desbloqueado.`);

            // Eliminar el usuario visualmente
            userBlock.remove();
        });
    });
});
