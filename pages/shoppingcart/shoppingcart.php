<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy - Carrito de Compras";
    $stylename = "shoppingcart.css"; 
    $javascript = "shoppingcart.js"; 

    require_once("../header.php");
   
    require_once("../header.php");

    switch ($_SESSION['Rol']) {
        case 'Estudiante':
            require_once("../studentNav.php");
            break;
        default:
            header("Location:../login/login.php");
            require_once("../emptyNav.php");
            break;
    }
?>

<section id="cartSection" class="back-eerie">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="header-container">
                    <img src="../resources/shopping-cart.svg" alt="Carrito de Compras" class="cart-icon movement">
                    <h1 class="title baby">Finalizar compra</h1>
                </div>
            </div>
           <!-- COLUMNA DE CURSOS A PAGAR -->
            <div class="col-8">
                <!--DATOS DUMMY -->
                <!--Curso 1 -->
                <div class="cart-item back-prussian">
                    <!-- <img src="../resources/Chef2.png" alt="Tacos del norte de México" class="cart-img">
                    <div class="cart-details">
                        <h5 class="tiny-name baby">Tacos del norte de México</h5>
                        <p class="detail baby">Martha Juarez</p>
                        <div>
                            <h5 class="tiny-name baby">Cal. 2.5</h5>
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/half-star.svg" alt="">
                        </div>
                        <h4 class="big-name baby">$200</h4>
                    </div>
                    <button class="red-button remove-button">Eliminar</button> -->
                </div>
            </div>
                    <!--COLUMNA DE PAGO -->
            <div class="col-4 summary back-prussian">
                <h2 class="name baby">Total</h2>
                <h3 class="big-name baby" id="course-price"></h3>

                <div>
                    <div>
                        <h3 class= "option baby"> Número de la tarjeta: </h3>
                        <input class="input" type="number" required id="tarjeta" name="tarjeta">
                    </div>
                    <div>
                        <h3 class= "option baby"> Fecha de vencimiento: </h3>
                        <input class="input" type="month" id="fecha" name="fecha" >
                    </div>
                    <div>
                        <h3 class= "option baby"> CVV: </h3>
                        <input class="input" type="text" required id="cvv" name="cvv">>
                    </div>
                    <div>
                        <h3 class= "option baby"> Nombre: </h3>
                        <input class="input" type="text" required id="nombre" name="nombre">
                    </div>
                    <div>
                        <h3 class= "option baby"> Apellido: </h3>
                        <input class="input" type="text" required id="apellido" name="apellido">
                    </div>
                </div>
                <button class="red-button checkout-button" onclick="payCourse();">Proceder al pago</button>

                <!-- SECCIÓN DE SUGERENCIAS -->
                <!-- <div class="suggestions">
                    <h4 class="suggestion-title baby">Sugerencias para ti</h4> -->
                    
                    <!-- Sugerencia 1 -->
                    <!-- <div class="suggestion-item">
                        <img src="../resources/Chef5.png" alt="Comida vegana" class="suggestion-img">
                        <div class="suggestion-details">
                            <h5 class="baby">Ceviche Peruano</h5>
                            <p class="baby">Carlos López</p>
                            <h4 class="baby">$300</h4>
                        </div>
                        <button class="add-button">Agregar</button>
                    </div> -->

                    <!-- Sugerencia 2 -->
                    <!-- <div class="suggestion-item">
                        <img src="../resources/Chef8.jpg" alt="Pizzas italianas" class="suggestion-img">
                        <div class="suggestion-details">
                            <h5 class="baby">Pizzas italianas</h5>
                            <p class="baby">Luca Rossi</p>
                            <h4 class="baby">$450</h4>
                        </div>
                        <button class="add-button" >Agregar</button>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
<script src="https://www.paypal.com/sdk/js?client-id=AaDnChw9DFweiZrrGcdkl_ezFjldcnTgKPpW3uLlVzQQ9P2Ms4XN3OcBxma8Q5ALaax_zOfMmReNxoJq&currency=MXN&locale=es_MX"></script>

<?php include("../footer.php"); ?>

