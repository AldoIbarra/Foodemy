<?php 
    $titlename = "Foodemy";
    $stylename = "certificate.css";
    $javascript = "certificate.js";

    require_once("../header.php");
?>

<section id="bannerSection" class="back-prussian">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-5 text-container">
            <h1 class="title baby">Generar Certificado</h1>
                <form id="certificado-form">
                    <div class="input-box">
                        <span class="option eerie">Nombre del estudiante:</span>
                        <input type="text" id="nombre-estudiante" placeholder="Nombre completo" required>
                    </div>
                    <div class="input-box">
                        <span class="option eerie">Nombre del curso:</span>
                        <input type="text" id="nombre-curso" placeholder="Nombre del curso" required>
                    </div>
                    <div class="input-box">
                        <span class="option eerie">Nombre del instructor:</span>
                        <input type="text" id="nombre-instructor" placeholder="Nombre del instructor" required>
                    </div>
                    <div class="input-box">
                        <span class="option eerie">Fecha de finalización:</span>
                        <input type="date" id="fecha-finalizacion" required>
                    </div>
                    <div class="button-container">
                        <button class="red-button" type="submit">Generar Certificado</button>
                    </div>
                        
                </form>
            </div>

            <div class="col-7 img-container full-height-img">
                <img src="../resources/Chef7.png" alt="Chef grande">
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
