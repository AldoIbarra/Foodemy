<?php
    $titlename = "Foodemy";
    $stylename = "pago.css";
   
    require_once("../header.php");
?>
<section id="dashboardSection">
    <div class="container">   
        <div class="login-container">
            <form action="" id="formulariosp">
                <h1 class="title baby">Proceder <span class="poppy"> pago</span></h1>
                <h2 class="option baby">Tarjetas de débito o crédito</h2>
                <h3 class="option baby">Visa, Mastercard y American Express</h3>
                <img class= "avatar" id="imagenPrevisualizada" src="../resources/visa.png" alt="Previsualización de imagen">
                <img class= "avatar" id="imagenPrevisualizada" src="../resources/American.png" alt="Previsualización de imagen">
                <img class= "avatar" id="imagenPrevisualizada" src="../resources/MasterCard.png" alt="Previsualización de imagen">
                
                <div class="input-div one">
                            <div class="i">
                            <i class="fa-regular fa-credit-card"></i>
                            </div>
                            <div>
                            <h3 class= "option baby"> Número de la tarjeta: </h3>
                            <input class="input" type="text" required id="tarjeta" name="tarjeta">
                        </div>
                </div>      

                <div class="input-div two">
                            <div class="i">
                            <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div>
                            <input class="input" type="month" id="fecha" name="fecha" >
                        </div>
                </div>

                <div class="input-div one">
                            <div class="i">
                            <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                            <h3 class= "option baby"> CVV: </h3>
                            <input class="input" type="text" required id="cvv" name="cvv">
                        </div>
                </div>

                <div class="input-div one">
                            <div class="i">
                            <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                            <h3 class= "option baby"> Nombre: </h3>
                            <input class="input" type="text" required id="nombre" name="nombre">
                        </div>
                </div>

                <div class="input-div one">
                            <div class="i">
                            <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                            <h3 class= "option baby"> Apellido: </h3>
                            <input class="input" type="text" required id="apellido" name="apellido">
                        </div>
                </div>

                

                <a class="paypala" href="">
                     <img class="paypal" src="../resources/Paypal.png" alt="Descripción de la imagen">
                </a>

                <button class="red-buttonb">
                       Procesar
                </button>

                        
                        
                        

                    
            </form>
        </div>
                    
                
    </div>
</section>

<script src='pago.js'></script>

<?php include("../footer.php"); ?>