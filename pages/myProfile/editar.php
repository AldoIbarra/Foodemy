<?php
    $titlename = "Foodemy";
    $stylename = "editar.css";
    $javascript = "editar.js";
   
    require_once("../header.php");
?>
<section id="dashboardSection">
    <div class="container">   
        <div class="login-container">
            <form action="" id="formulariosp">
                <img class= "avatar" id="imagenPrevisualizada" src="../resources/perfil5.jpg" alt="Previsualización de imagen">
                <h1 class="title baby">Editar <span class="poppy"> usuario</span></h1>
                        
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
                        

                <button class="red-buttonb" onclick="window.location.href='profile.php';">
                        Guardar cambios
                </button>

                        
                        
                        

                    
            </form>
        </div>
                    
                
    </div>
</section>

<script src='editar.js'></script>

<?php include("../footer.php"); ?>