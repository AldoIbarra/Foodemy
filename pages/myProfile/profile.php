<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "profile.css";
    $javascript = "profile.js";
   
    require_once("../header.php");

    switch ($_SESSION['Rol']) {
        case 'Estudiante':
            require_once("../studentNav.php");
            break;
        case 'Instructor':
            require_once("../teacherNav.php");
            break;
        case 'Administrador':
            require_once("../adminNav.php");
            break;
        default:
            header("Location:../login/login.php");
            require_once("../emptyNav.php");
            break;
    }
?>

<section id="bannerSection" >
    <div class="container">
        <section class="userProfile">
            <div class="profile">
                <img width="250px" height="250px" alt="profile" id="userImg" src="" alt="">
            </div>
        </section>

        <section class="userDetails card">
            <div class="userName">
                <h1 class="title prussian" id="userName"></h1>
                <p class="big-name mantis" id="userType"></p>
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
            <div class="basic_info">
                <ul>
                    <li class="birthday">
                        <h1 class="tiny-name eerie">Cumpleaños:</h1>
                        <span class="info" id="birthDate"></span>
                    </li>
                    <li class="sex">
                        <h1 class="tiny-name eerie">Género:</h1>
                        <span id="gender" class="info"></span>
                    </li>
                </ul>
                <a href="editar.php" class="red-button">Editar perfil</a>
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