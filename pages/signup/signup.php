<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "signup.css";
    $javascript = "signup.js";
    require_once("../header.php");

    if($_SESSION){
        header("Location:../myProfile/profile.php");
    }else{
        require_once("../emptyNav.php");
    }
?>


    
    <img  class= "img-fondo" src="../resources/registro.jpeg">
    <div class="container">   
            <div class= "img">
                <a class="red-button" href="../login/login.php">
                    Iniciar sesión
                </a>
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
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Otro">Otro</option>
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

                    <div class="input-div one">
                        <div class="i">
                            <i class="fa-solid fa-venus-mars"></i>
                        </div>
                        <div>
                            <h3 class= "option baby"> Tipo de usuario: </h3>
                            <select  class= "option eerie" id="usuarioTipo" name="usuarioTipo" >
                                <option value="">--Seleccionar--</option>
                                <option value="Estudiante">Estudiante</option>
                                <option value="Instructor">Instructor</option>
                            </select>
                        </div>
                    </div>
                    

                    <button class="red-button">
                          ¡Registrarse!
                    </button>
                </form>
            </div>
                
            
    </div>

<?php 
    include("../footer.php");
?>