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
           <!-- COLUMNA DE CURSOS A PAGAR -->
<div class="col-8">
    <div class="header-container">
        <img src="../resources/shopping-cart.svg" alt="Carrito de Compras" class="cart-icon movement">
        <h1 class="title baby">  Carrito de Compras</h1>
    </div>
                <!--DATOS DUMMY -->
                <!--Curso 1 -->
                <div class="cart-item back-prussian">
                    <img src="../resources/Chef2.png" alt="Tacos del norte de México" class="cart-img">
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
                    <button class="red-button remove-button">Eliminar</button>
                </div>
                <!--Curso 2 -->
                <div class="cart-item back-prussian">
                    <img src="../resources/Chef3.png" alt="Comida china fácil" class="cart-img">
                    <div class="cart-details">
                        <h5 class="tiny-name baby">Comida china fácil</h5>
                        <p class="detail baby">Manuel Chapa</p>
                        <div>
                            <h5 class="tiny-name baby">Cal. 5</h5>
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                        </div>
                        <h4 class="big-name baby">$500</h4>
                    </div>
                    <button class="red-button remove-button">Eliminar</button>
                </div>
                <!--Nivel -->
              <div class="cart-item back-prussian">
                    <img src="../resources/Chef4.png" alt="Pastel de zanahoria" class="cart-img">
                    <div class="cart-details">
                        <h5 class="tiny-name baby">Pastel de zanahoria</h5>
                        <p class="detail baby">Ross Lynch</p>
                        <div>
                            <h5 class="tiny-name baby">Cal. 4</h5>
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                            <img src="../resources/star.svg" alt="">
                        </div>
                        <h4 class="big-name baby">$100</h4>
                    </div>
                    <button class="red-button remove-button">Eliminar</button>
                </div>
            </div>
            <!--COLUMNA DE PAGO -->
            <div class="col-4 summary back-prussian">
                <h2 class="name baby">Resumen</h2>
                <!--Listado de los cursos (consu nombre) -->
                
                <!--Totales (numeros de curso y costo total) -->
                <p class="description baby">Total de cursos: 3</p>
                <h3 class="big-name baby">$800</h3>
                <button class="red-button checkout-button" onclick="window.location.href='pago.php';">Proceder al pago</button>

                <!-- SECCIÓN DE SUGERENCIAS -->
                <div class="suggestions">
        <h4 class="suggestion-title baby">Sugerencias para ti</h4>
        
        <!-- Sugerencia 1 -->
        <div class="suggestion-item">
            <img src="../resources/Chef5.png" alt="Comida vegana" class="suggestion-img">
            <div class="suggestion-details">
                <h5 class="baby">Ceviche Peruano</h5>
                <p class="baby">Carlos López</p>
                <h4 class="baby">$300</h4>
            </div>
            <button class="add-button">Agregar</button>
        </div>

        <!-- Sugerencia 2 -->
        <div class="suggestion-item">
            <img src="../resources/Chef8.jpg" alt="Pizzas italianas" class="suggestion-img">
            <div class="suggestion-details">
                <h5 class="baby">Pizzas italianas</h5>
                <p class="baby">Luca Rossi</p>
                <h4 class="baby">$450</h4>
            </div>
            <button class="add-button" >Agregar</button>
        </div>
    </div>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>

