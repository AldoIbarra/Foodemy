<?php 
    $titlename = "Foodemy";
    $stylename = "category.css"; /* Ahora usa category.css */
    $javascript = "category.js";

    require_once("../header.php");
?>

<section id="bannerSection" class="back-prussian">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-5 text-container">
            <h1 class="title baby">Categorías</h1>
                <div class="input-box">
                    <span class="details"></span>
                    <select id="number-of-categories" required>
                        <option value="categorías">Categorías</option>
                        <option value="1">Cocina Saludable</option>
                        <option value="2">Cocina Internacional</option>
                        <option value="3">Repostería y Pastelería</option>
                        <option value="4">Cocina Vegetariana y Vegana</option>
                        <option value="5">Técnicas de Cocina Básicas</option>
                        <option value="6">Cocina de Temporada</option>
                        <option value="7">Platos Rápidos</option>
                        <option value="+ Agregar">+ Agregar</option>
                    </select>
                </div>

                <div id="dynamic-categories-container"></div>
            </div>

            <div class="col-7 img-container full-height-img">
                <img src="../resources/Chef6.png" alt="Chef grande">
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
