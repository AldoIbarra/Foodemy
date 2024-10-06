<?php
    $titlename = "Foodemy";
    $stylename = "login.css";
   

    require_once("../header.php");
?>


    
    <img  class= "img-fondo" src="../resources/fondo.jpg">
    <div class="container">   
            <div class= "img">
                
                <button class="red-button">
                          ¡Registrarse!
                </button>
            </div>

            <div class="login-container">
            <form action="" id="formulario">
                     <img class= "avatar" src="../resources/logoCursosCocina.jpg" alt="Imagen predeterminada" >
                     <h1 class="title baby">Bienvenido <span class="poppy">.</span></h1>
                    
                     <div class="input-div one">
                        <div class="i">
                        <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                        <h3 class= "option baby"> Correo </h3>
                        <input class="input" type="email"  required id="correo" name="correo">
                    </div>
                    </div>
                    

                    <div class="input-div two">
                        <div class="i">
                        <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                        <h3 class= "option baby"> Contraseña </h3>
                        <input class="input" type="password" required id="contra" name="contra">
                    </div>
                    </div>
                    
                    <a href="#" class="detail baby">Olvide mi contraseña.</a>

                    <button class="red-buttonb">
                          Iniciar sesión
                    </button>

                    
                    
                    

                   
                </form>
            </div>
                
            
            </div>
            <script src='login.js'></script>

<?php include("../footer.php"); 


?>