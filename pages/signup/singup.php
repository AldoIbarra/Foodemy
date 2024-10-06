<?php
    $titlename = "Foodemy";
    $stylename = "singup.css";
   

    require_once("../header.php");
?>


    
    <img  class= "img-fondo" src="../resources/registro.jpeg">
    <div class="container">   
            <div class= "img">
                <button class="red-button" onclick="window.location.href='../Foodemy/pages/login/login.php';">
                    Iniciar sesión
                </button>
            </div>

            <div class="login-container">
            <form action="" id="formulariosp">
                     <img class= "avatar" id="imagenPrevisualizada" src="../resources/logoCursosCocina.jpg" alt="Imagen predeterminada" >
                     <h1 class="title baby">Unirme <span class="poppy"> ahora</span></h1>
                    
                     <div class="input-div two">
                        <div class="i">
                        <i class="fa-solid fa-image"></i>
                        </div>
                        <div>
                        <input class="input" id="inputFoto" name="inputFoto" type="file"class="box" accept="image/jpg, image/jpeg, image/png">
                    </div>
                    </div>

                     <div class="input-div one">
                        <div class="i">
                        <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                        <h3 class= "option baby"> Nombre completo: </h3>
                        <input class="input" type="text" required id="nombre" name="nombre">
                    </div>
                    </div>
                    

                    <div class="input-div two">
                        <div class="i">
                        <i class="fa-solid fa-venus-mars"></i>
                        </div>
                        <div>
                        <h3 class= "option baby"> Género: </h3>
                        <select  class= "option eerie" id="sexo" name="sexo" >
                            <option value="">--Seleccionar--</option>
                            <option value="opcion1">Femenino</option>
                            <option value="opcion2">Masculino</option>
                            <option value="opcion3">No decir</option>
                        </select>
                    </div>
                    </div>

                    <div class="input-div two">
                        <div class="i">
                        <i class="fa-solid fa-cake-candles"></i>
                        </div>
                        <div>
                        <input class="input" max="2006-01-01" type="date" id="fecha" name="fecha" >
                    </div>
                    </div>

                    <div class="input-div one">
                        <div class="i">
                        <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                        <h3 class= "option baby"> Correo: </h3>
                        <input class="input" type="email"  required id="correo" name="correo">
                    </div>
                    </div>

                    <div class="input-div one">
                        <div class="i">
                        <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                        <h3 class= "option baby"> Contraseña: </h3>
                        <input class="input" type="password"  required id="contra" name="contra">
                    </div>
                    </div>
                    

                    <button class="red-buttonb">
                          ¡Registrarse!
                    </button>

                    
                    
                    

                   
                </form>
            </div>
                
            
            </div>
            <script src='signup.js'></script>

<?php include("../footer.php"); 


?>