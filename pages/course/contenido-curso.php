<?php
    $titlename = "Foodemy - Videos de Cocina";
    $stylename = "contenido-curso.css";
    $javascript = "contenido-curso.js";
   
    require_once("../header.php");
?>

<section id="videoSection" class="back-prussian">
    <div class="container">
        <div class="row">
            <!-- Reproductor de Video -->
            <div class="col-8 video-player-container">
                <video id="videoPlayer" width="100%" controls>
                    <source src="../resources/video.mp4" type="video/mp4">
                    Tu navegador no soporta la reproducción de videos.
                </video>
                <h3 id="videoTitle" class="title baby">Receta 1: Dumplings</h3>
            </div>

            <!-- Lista de Videos -->
            <div class="col-4 video-list-container">
                <h4 class="title baby">Lista de videos</h4>
                <ul class="video-list">
                    <li class="video-item" data-video="../resources/video1.mp4" data-title="Receta 1: Dumplings">
                        <img src="../resources/dumplings.png" alt="Dumplings">
                        <span>Receta 1: Dumplings</span>
                    </li>
                    <li class="video-item" data-video="../resources/video2.mp4" data-title="Receta 2: Rollos Primavera">
                        <img src="../resources/rolls.png" alt="Rollos Primavera">
                        <span>Receta 2: Rollos Primavera</span>
                    </li>
                    <li class="video-item" data-video="../resources/video3.mp4" data-title="Receta 3: Arroz con camarones">
                        <img src="../resources/rice.png" alt="Arroz con camarones">
                        <span>Receta 3: Arroz con camarones</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
