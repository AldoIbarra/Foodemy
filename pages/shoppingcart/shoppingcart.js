var session;
var courseId;
var course;
const urlParams = new URLSearchParams(window.location.search);
$( document ).ready(function() {
    $.ajaxSetup({cache: false})
    $.get('../../api/getSession.php', function (data) {
        if(data){
            session = JSON.parse(data);
            console.log(session);
            courseId = urlParams.get('id');
            console.log(courseId);
            fetchCourseInfo(courseId);
        }else{
            console.error("Error al analizar JSON");
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // // Funcionalidad para los botones "Agregar"
    // const addButtons = document.querySelectorAll(".add-button");
    // addButtons.forEach(button => {
    //     button.addEventListener("click", function() {
    //         const suggestionItem = this.closest(".suggestion-item");
    //         const courseName = suggestionItem.querySelector("h5").innerText;
    //         const coursePrice = suggestionItem.querySelector("h4").innerText;

    //         // Crear un nuevo elemento de carrito
    //         const cartItem = document.createElement("div");
    //         cartItem.className = "cart-item back-prussian";
    //         cartItem.innerHTML = `
    //             <img src="${suggestionItem.querySelector("img").src}" alt="${courseName}" class="cart-img">
    //             <div class="cart-details">
    //                 <h5 class="tiny-name baby">${courseName}</h5>
    //                 <p class="detail baby">Instructor Desconocido</p>
    //                 <div>
    //                     <h5 class="tiny-name baby">N/A</h5>
    //                     <img src="../resources/star.svg" alt="">
    //                 </div>
    //                 <h4 class="big-name baby">${coursePrice}</h4>
    //             </div>
    //             <button class="red-button remove-button">Eliminar</button>
    //         `;

    //         // Añadir el nuevo elemento al carrito
    //         document.querySelector(".col-8").appendChild(cartItem);

    //         // Actualizar total
    //         updateTotal();

    //         // Mostrar mensaje
    //         alert(`El curso "${courseName}" ha sido agregado al carrito.`);
    //     });
    // });

    // // Funcionalidad para los botones "Eliminar"
    // document.querySelector(".col-8").addEventListener("click", function(e) {
    //     if (e.target.classList.contains("remove-button")) {
    //         const cartItem = e.target.closest(".cart-item");
    //         const courseName = cartItem.querySelector(".tiny-name").innerText;

    //         // Eliminar el curso del carrito
    //         cartItem.remove();

    //         // Actualizar total
    //         updateTotal();

    //         // Mostrar mensaje
    //         alert(`El curso "${courseName}" ha sido eliminado del carrito.`);
    //     }
    // });

    // // Funcionalidad para el botón "Proceder al pago"
    // const checkoutButton = document.querySelector(".checkout-button");
    // checkoutButton.addEventListener("click", function() {
    //     alert("Gracias por tu compra. ¡Has procedido al pago con éxito!");
    //     // Aquí puedes agregar la lógica para proceder con la compra
    // });

    // // Función para actualizar el total
    // function updateTotal() {
    //     const cartItems = document.querySelectorAll(".col-8 .cart-item");
    //     let total = 0;
    //     cartItems.forEach(item => {
    //         const priceText = item.querySelector(".big-name").innerText.replace('$', '');
    //         total += parseFloat(priceText);
    //     });

    //     document.querySelector(".summary h3.big-name").innerText = `$${total}`;
    //     document.querySelector(".summary .description").innerText = `Total de cursos: ${cartItems.length}`;
    // }
});

function fetchCourseInfo(courseId) {
    const params = new URLSearchParams({ option: 'getCourseById' });

    $.ajax({
        type: "POST",
        url: "../../api/courseController.php?" + params.toString(),
        dataType: "json",
        data: { id_curso: courseId }, // Pasamos el ID del curso como parámetro
        success: function(response) {
            console.log(response);
            course = response.course;
            setCourseInfo();
        }
    });
}

function setCourseInfo(){
    course = course;
    console.log(course);
    var value = '<img src="../' + course.Curso_Imagen + '" alt="' + course.Curso_Titulo + '" class="cart-img"><div class="cart-details"><h5 class="tiny-name baby">' + course.Curso_Titulo + '</h5><p class="detail baby">' + course.Instructor_Nombre + '</p><div><h5 class="tiny-name baby">Cal. 2.5</h5><img src="../resources/star.svg" alt=""><img src="../resources/star.svg" alt=""><img src="../resources/half-star.svg" alt=""></div><h4 class="big-name baby">$' + course.Curso_Precio + '</h4></div>';
    $('.cart-item').append(value);
    $('#course-price').text('$' + course.Curso_Precio);
}

function payCourse(){
    if($('#tarjeta').val() == '' || $('#fecha').val() == '' || $('#cvv').val() == '' || $('#nombre').val() == '' || $('#apellido').val() == ''){
        alert('Debes llenar los campos de pago');
        return;
    }
    console.log('manda a pagar el curso');
    console.log(course);
    formData = new FormData();
    formData.append('option', 'buyCourse');
    formData.append('ID_Usuario_Instructor', course.Instructor_ID);
    formData.append('ID_Usuario_Estudiante', session.ID_Usuario);
    formData.append('ID_Curso', course.ID_Curso);
    formData.append('Total_Pagado', parseFloat(course.Curso_Precio));
    formData.append('Forma_Pago', 'Tarjeta de crédito');
    formData.append('Curso_Comprado_Totalmente', 1);
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "../../api/courseController.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert(`¡Curso comprado con exito!`);
            // window.location.replace("../login/login.php");
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.log('error');
            console.log(error);
        },
    });
}