<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "profile.css";
    $javascript = "profile.js";
   
    if($_SESSION){
        require_once("../userHeader.php");
    }else{
        header("Location:../login/login.php");
        require_once("../header.php");
    }
?>

<section id="bannerSection" >
 <!-- ===== ===== Body Main-Background ===== ===== -->
    <div class="container">
        <!-- ===== ===== User Main-Profile ===== ===== -->
        <section class="userProfile">
            <div class="profile">
                <figure><img src="../resources/perfil5.jpg" alt="profile" width="250px" height="250px"></figure>
            </div>
        </section>


        <!-- ===== ===== Work & Skills Section ===== ===== -->
        <section class="work_skills card">

            <!-- ===== ===== Work Contaienr ===== ===== -->
            <div class="work">
                <div class="primary">
                    <h1 class="tiny-name eerie" >Acerca de mí </h1>
                    <p class="detail baby"> Apasionado por la comida  <br> mexicanaaaa</p>
                </div>
                <a href="editar.php" class="red-button">Editar perfil</a>
            </div>

                
            
        </section>


        <!-- ===== ===== User Details Sections ===== ===== -->
        <section class="userDetails card">
            <div class="userName">
                <?php
                    if($_SESSION){
                        echo '<h1 class="title prussian">'.$_SESSION['Nombre_Completo'].'</h1>';
                    }else{
                        echo '<h1 class="title prussian">Byun Baekhyun</h1>';
                    }
                ?>
                <?php
                    if($_SESSION){
                        echo '<p class="big-name mantis">'.$_SESSION['Rol'].'</p>';
                    }else{
                        echo '<p class="big-name mantis">Estudiante</p>';
                    }
                ?>
                
            </div>

            <div class="rank">
                <h1 class="heading">Cursos completados</h1>
                <span>16</span>
                <div class="rating">
                    <i class="ri-star-fill rate"></i>
                    <i class="ri-star-fill rate"></i>
                    <i class="ri-star-fill rate"></i>
                    <i class="ri-star-fill rate"></i>
                    <i class="ri-star-fill rate underrate"></i>
                </div>
            </div>

            <div class="btns">
                <ul>
                    <li class="sendMsg ">
                    <button class="blue-button" >
                    Mensajes
                </button>
                    </li>

                    <li class="sendMsg">
                    <button class="blue-button" >
                    Reportar perfil
                </button>
                    </li>
                </ul>
            </div>
        </section>


        <!-- ===== ===== Timeline & About Sections ===== ===== -->
        <section class="timeline_about card">
        

            <div class="basic_info">
                <h1 class="big-name poppy">Información básica</h1>
                <ul>
                    <li class="birthday">
                        <h1 class="tiny-name eerie">Cumpleaños:</h1>
                        <?php
                            if($_SESSION){
                                echo '<span class="info">'.$_SESSION['Fecha_Nacimiento'].'</span>';
                            }else{
                                echo '<span class="info">Mayo 5, 2000</span>';
                            }
                        ?>
                        
                    </li>

                    <li class="sex">
                        <h1 class="tiny-name eerie">Género:</h1>
                        <?php
                            if($_SESSION){
                                echo '<span class="info">'.$_SESSION['Genero'].'</span>';
                            }else{
                                echo '<span class="info">Masculino</span>';
                            }
                        ?>
                        
                    </li>
                </ul>
            </div>
            
        
        </div>
        </section>
    </div>
</section>
<section id="dashboardSection" class="back-eerie">
    <span class="second_bg">

    <div class="col-5">
    <h1 class="title baby">Mis <span class="poppy">cursos</span> </h1>
</div>

    <div class="containerb">
        <div class="row">
            <div class="col-3 course">
                <img src="../resources/Chef2.png" alt="">
                <h5 class="tiny-name baby">Tacos del norte de México</h5>
                <p class="detail baby">Martha Juarez</p>
                <div>
                    <h5 class="tiny-name baby">2.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="mantis">80%</span> </h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef3.png" alt="">
                <h5 class="tiny-name baby">Comida china fácil</h5>
                <p class="detail baby">Manuel Chapa</p>
                <div>
                    <h5 class="tiny-name baby">5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="poppy">30%</span> </h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef4.png" alt="">
                <h5 class="tiny-name baby">Comida típica brasileña</h5>
                <p class="detail baby">Eliud Ramirez</p>
                <div>
                    <h5 class="tiny-name baby">5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="mantis">60%</span> </h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef5.png" alt="">
                <h5 class="tiny-name baby">Cenas romanticas francesas</h5>
                <p class="detail baby">José Urrutia</p>
                <div>
                    <h5 class="tiny-name baby">3.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="poppy">10%</span> </h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef2.png" alt="">
                <h5 class="tiny-name baby">Tacos del norte de México</h5>
                <p class="detail baby">Martha Juarez</p>
                <div>
                    <h5 class="tiny-name baby">2.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="mantis">80%</span> </h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef4.png" alt="">
                <h5 class="tiny-name baby">Comida típica brasileña</h5>
                <p class="detail baby">Eliud Ramirez</p>
                <div>
                    <h5 class="tiny-name baby">5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="mantis">60%</span> </h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef5.png" alt="">
                <h5 class="tiny-name baby">Cenas romanticas francesas</h5>
                <p class="detail baby">José Urrutia</p>
                <div>
                    <h5 class="tiny-name baby">3.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="poppy">10%</span> </h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef2.png" alt="">
                <h5 class="tiny-name baby">Tacos del norte de México</h5>
                <p class="detail baby">Martha Juarez</p>
                <div>
                    <h5 class="tiny-name baby">2.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">Progreso <span class="mantis">80%</span> </h4>
            </div>
        </div>
    </div>
    </span>
    
</section>

<?php 
    include("../footer.php"); 
?>