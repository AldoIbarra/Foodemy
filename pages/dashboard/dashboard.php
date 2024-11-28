<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "dashboard.css";
    $javascript = "dashboard.js";
   
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
            require_once("../emptyNav.php");
            break;
    }
?>


<section id="bannerSection" class="back-eerie">
    <div class="container">
        <div class="row">
            <div class="col-5 text-container">
                <h1 class="title baby">Cientos de <span class="poppy">cursos</span> de <span class="poppy">cocina</span>, prepara tus platillos favoritos de tooodo el <span class="poppy">mundo</span> desde casa.</h1>
            </div>
            <div class="col-7 img-container">
                <img src="../resources/Chef1.png" alt="">
            </div>
        </div>
    </div>
</section>
<section id="dashboardSection" class="back-prussian">
    <div class="container">
        <div class="row" id="principal-courses">
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>