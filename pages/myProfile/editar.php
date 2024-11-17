<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "editar.css";
    $javascript = "editar.js";
   
    require_once("../header.php");

    switch ($_SESSION['Rol']) {
        case 'Estudiante':
            require_once("../studentNav.php");
            break;
        case 'Instructor':
            require_once("../teacherNav.php");
            break;
        case 'Admin':
            require_once("../adminNav.php");
            break;
        default:
            header("Location:../login/login.php");
            require_once("../emptyNav.php");
            break;
    }
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
                            <?php
                                if($_SESSION){
                                    echo '<input value="'.$_SESSION['Nombre_Completo'].'" class="input" type="text" required id="nombre" name="nombre">';
                                }else{
                                    echo '<input class="input" type="text" required id="nombre" name="nombre">';
                                }
                            ?>
                        </div>
                </div>
                        

                <div class="input-div two">
                            <div class="i">
                            <i class="fa-solid fa-venus-mars"></i>
                            </div>
                            <div>
                            <h3 class= "option baby"> Género: </h3>
                            <select  class= "option eerie" id="sexo" name="sexo" >
                                <option <?= $_SESSION && ($_SESSION['Genero'] == '' || $_SESSION['Genero'] == null) ? ' selected="selected"' : '';?> value="">--Seleccionar--</option>
                                <option <?= $_SESSION && $_SESSION['Genero'] == 'Femenino' ? ' selected="selected"' : '';?> value="Femenino">Femenino</option>
                                <option <?= $_SESSION && $_SESSION['Genero'] == 'Masculino' ? ' selected="selected"' : '';?>  value="Masculino">Masculino</option>
                                <option <?= $_SESSION && $_SESSION['Genero'] == 'Otro' ? ' selected="selected"' : '';?>  value="Otro">Otro</option>
                            </select>
                        </div>
                </div>

                <div class="input-div two">
                            <div class="i">
                            <i class="fa-solid fa-cake-candles"></i>
                            </div>
                            <div>
                            <input <?= $_SESSION && $_SESSION['Fecha_Nacimiento'] != '' && $_SESSION['Fecha_Nacimiento'] != null ? 'value="'.$_SESSION['Fecha_Nacimiento'].'"' : '';?>  class="input" max="2006-01-01" type="date" id="fecha" name="fecha" >
                        </div>
                </div>

                <?php 
                if($_SESSION){
                    echo '<div class="input-div two" style="display: none;">
                        <input value="'.$_SESSION['ID_Usuario'].'" class="input" type="text" id="id" name="id">
                    </div>';
                    }
                ?>
                        

                <button class="red-buttonb">
                        Guardar cambios
                </button>
            </form>
        </div>
                    
                
    </div>
</section>

<?php include("../footer.php"); ?>