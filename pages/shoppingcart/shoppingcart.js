document.addEventListener("DOMContentLoaded", function() {
    // Funcionalidad para los botones "Agregar"
    const addButtons = document.querySelectorAll(".add-button");
    addButtons.forEach(button => {
        button.addEventListener("click", function() {
            const suggestionItem = this.closest(".suggestion-item");
            const courseName = suggestionItem.querySelector("h5").innerText;
            const coursePrice = suggestionItem.querySelector("h4").innerText;

            // Crear un nuevo elemento de carrito
            const cartItem = document.createElement("div");
            cartItem.className = "cart-item back-prussian";
            cartItem.innerHTML = `
                <img src="${suggestionItem.querySelector("img").src}" alt="${courseName}" class="cart-img">
                <div class="cart-details">
                    <h5 class="tiny-name baby">${courseName}</h5>
                    <p class="detail baby">Instructor Desconocido</p>
                    <div>
                        <h5 class="tiny-name baby">N/A</h5>
                        <img src="../resources/star.svg" alt="">
                    </div>
                    <h4 class="big-name baby">${coursePrice}</h4>
                </div>
                <button class="red-button remove-button">Eliminar</button>
            `;

            // Añadir el nuevo elemento al carrito
            document.querySelector(".col-8").appendChild(cartItem);

            // Actualizar total
            updateTotal();

            // Mostrar mensaje
            alert(`El curso "${courseName}" ha sido agregado al carrito.`);
        });
    });

    // Funcionalidad para los botones "Eliminar"
    document.querySelector(".col-8").addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-button")) {
            const cartItem = e.target.closest(".cart-item");
            const courseName = cartItem.querySelector(".tiny-name").innerText;

            // Eliminar el curso del carrito
            cartItem.remove();

            // Actualizar total
            updateTotal();

            // Mostrar mensaje
            alert(`El curso "${courseName}" ha sido eliminado del carrito.`);
        }
    });

    // Funcionalidad para el botón "Proceder al pago"
    const checkoutButton = document.querySelector(".checkout-button");
    checkoutButton.addEventListener("click", function() {
        alert("Gracias por tu compra. ¡Has procedido al pago con éxito!");
        // Aquí puedes agregar la lógica para proceder con la compra
    });

    // Función para actualizar el total
    function updateTotal() {
        const cartItems = document.querySelectorAll(".col-8 .cart-item");
        let total = 0;
        cartItems.forEach(item => {
            const priceText = item.querySelector(".big-name").innerText.replace('$', '');
            total += parseFloat(priceText);
        });

        document.querySelector(".summary h3.big-name").innerText = `$${total}`;
        document.querySelector(".summary .description").innerText = `Total de cursos: ${cartItems.length}`;
    }
});
