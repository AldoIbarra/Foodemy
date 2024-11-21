<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "detallecurso.css";
    $javascript = "detallecurso.js";
   
    require_once("../header.php");
?>

<section id="bannerSection" class="back-prussian">
    <div class="container">
        <div class="row">
            <div class="col-6 text-container">
                <h5 class="title baby">Comida China fácil</h5>
                <p class="description baby">Aprende las mejores recetas de este enigmatico país, elaboradas de la manera más sencilla con ingredientes que tenemos en casa.</p>
                <p class="option mantis">Asiatico</p>
                <p class="detail baby">Manuel Chapa</p>
                <div class="rate-stars">
                    <h5 class="tiny-name baby">5</h5>
                    <img src="../resources/stars.png" alt="">
                </div>
                <div class="price-and-button">
                    <h4 class="title baby">$100</h4>
                </div>
            </div>
            <div class="col-6 img-container">
                <img src="../resources/chefCourse.png" alt="">
            </div>
        </div>
    </div>
</section>

<section id="levelSection" class="back-eerie baby">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="headers">
                    <h3 class="title">Contenido</h3>
                    <h4 class="description">3 niveles</h4>
                </div>
                <div class="levels">
                    <div class="level">
                        <img src="../resources/dumplings.png" alt="">
                        <div>
                            <h4 class="name">Dumplings</h4>
                        </div>
                    </div>
                    <div class="level">
                        <img src="../resources/rolls.png" alt="">
                        <div>
                            <h4 class="name">Rollos Primavera</h4>
                        </div>
                    </div>
                    <div class="level">
                        <img src="../resources/rice.png" alt="">
                        <div>
                            <h4 class="name">Arroz con camarones</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="commentSection" class="back-eerie baby">
    <div class="container">
        <div class="row">
            <div class="col-12 comments-body">
                <h3 class="title">Comentarios</h3>
                <div class="comments-container">
                    <div class="comment">
                        <img src="../resources/profilepic.png" alt="">
                        <div class="texts-container">
                            <div class="name-and-stars">
                                <h5 class="name">José manuel</h5>
                                <img src="../resources/stars.png" alt="">
                            </div>
                            <p class="description">Me gustó mucho, no era broma que puedes usar cualquier cosa jaja</p>
                        </div>
                    </div>
                    <div class="comment">
                        <img src="../resources/profilepic.png" alt="">
                        <div class="texts-container">
                            <div class="name-and-stars">
                                <h5 class="name">Antonio Guevara</h5>
                                <img src="../resources/stars.png" alt="">
                            </div>
                            <p class="description">Está Genial</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>