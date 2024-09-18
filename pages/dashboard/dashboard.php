<?php
    $titlename = "Foodemy";
    $stylename = "dashboard.css";
    $javascript = "dashboard.js";
   
    require_once("../header.php");
?>


<section id="bannerSection" class="back-eerie">
    <div class="container">
        <div class="row">
            <div class="col-5 text-container">
                <h1 class="title baby">Cientos de <span class="poppy">cursos</span> de <span class="poppy">cocina</span>, prepara tus platillos favoritos de todo el <span class="poppy">mundo</span> desde casa.</h1>
            </div>
            <div class="col-7 img-container">
                <img src="../resources/Chef1.png" alt="">
            </div>
        </div>
    </div>
</section>
<section id="dashboardSection" class="back-prussian">
    <div class="container">
        <div class="row">
            <div class="col-3 course">
                <img src="../resources/Chef2.png" alt="">
                <h5 class="name baby">Tacos del norte de México</h5>
                <p class="detail baby">Martha Juarez</p>
                <div>
                    <h5 class="name baby">2.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">$100</h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef3.png" alt="">
                <h5 class="name baby">Comida china fácil</h5>
                <p class="detail baby">Manuel Chapa</p>
                <div>
                    <h5 class="name baby">5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                </div>
                <h4 class="big-name baby">$100</h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef4.png" alt="">
                <h5 class="name baby">Comida típica brasileña</h5>
                <p class="detail baby">Eliud Ramirez</p>
                <div>
                    <h5 class="name baby">5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                </div>
                <h4 class="big-name baby">$100</h4>
            </div>
            <div class="col-3 course">
                <img src="../resources/Chef5.png" alt="">
                <h5 class="name baby">Cenas romanticas francesas</h5>
                <p class="detail baby">José Urrutia</p>
                <div>
                    <h5 class="name baby">3.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">$100</h4>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>