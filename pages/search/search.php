<?php
    $titlename = "Foodemy - Resultados de Búsqueda";
    $stylename = "search.css";
    $javascript = "search.js";

    require_once("../header.php");
?>

    
 


<!-- SECCIÓN DE RESULTADOS DE BÚSQUEDA -->
<section id="searchResultsSection" class="back-eerie">
    <div class="container">
        <div class="row search">
            <div class="col-12">
                <form id="searchBarContainer" class="back-eerie">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="text" placeholder="Buscar..." id="search-input" name="search-input" style="flex: 2; width: 350px;">
                        <select id="category-select" name="category" class="form-control" style="width: 250px;">
                            <option value="">Cualquiera</option>
                        </select>
                        <!-- Campos de rango de fechas -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <label for="start-date" class="detail baby" style="color: white;">Desde:</label>
                            <input type="date" id="date-start" name="date-start" class="form-control" style="width: 150px;">
                            <label for="end-date" class="detail baby" style="color: white;">Hasta:</label>
                            <input type="date" id="date-end" name="date-end" class="form-control" style="width: 150px;">
                        </div>
                        <button type="submit"><img src="../resources/search.svg" alt="Buscar"></button>
                    </div>
                </form>
            </div>
        </div>



        
        <!-- SECCIÓN DE RESULTADO DE "---" -->
        <div class="row">
            <div class="col-12">
                <br>
                <h2 class="title baby" id="results">Resultados de búsqueda para: "<span id="search-query"></span>"</h2>
            </div>
        </div>

        <!-- SECCIÓN DE RESULTADOS DE BÚSQUEDA -->
        <div class="results-container">
            <!-- Curso -->
            <div class="course">
                <img src="../resources/Chef2.jpg" alt="Tacos del norte de México">
                <h5 class="tiny-name baby">Tacos del norte de México</h5>
                <p class="detail baby">Martha Juarez</p>
                <div class="rate-stars">
                    <h5 class="tiny-name baby">2.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">$100</h4>
                <p class="detail baby">hace un mes</p>
            </div>
            <!-- Nivel -->
            <div class="level">
                <img src="../resources/comidamex.jpg" alt="Comida china fácil">
                <h5 class="tiny-name baby">Nivel: Mexicano </h5>
                <p class="detail baby">Manuel Chapa</p>
                <div>
                    <h5 class="tiny-name baby">5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                </div>
                <h4 class="big-name baby">$300</h4>
                <p class="detail baby">nuevo</p>
            </div>
            <!-- Usuarios -->
            <div class="user">
                <img src="../resources/user1.jpeg" id="user-image" alt="Usuario Chilito Mexicano">
                <h5 class="tiny-name baby">Chilito Mexicano</h5>
                <p class="detail baby">Alumno</p>
            </div>
            <div class="user">
                <img src="../resources/gatitomexa.jpg" id="user-image" alt="Usuario Gatito Mexa">
                <h5 class="tiny-name baby">Gatito Mexa</h5>
                <p class="detail baby">Instructor</p>
            </div>
            <!-- Curso -->
            <div class="course">
                <img src="../resources/chef13.jpg" alt="Tacos del norte de México">
                <h5 class="tiny-name baby">Introducción a la comida mexicana</h5>
                <p class="detail baby">Sara Maldonado</p>
                <div>
                    <h5 class="tiny-name baby">3.5</h5>
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/star.svg" alt="">
                    <img src="../resources/half-star.svg" alt="">
                </div>
                <h4 class="big-name baby">$250</h4>
                <p class="detail baby">hace un año</p>
            </div>
            <!-- Más resultados... -->
        </div>
    </div>
</section>


<?php include("../footer.php"); ?>
