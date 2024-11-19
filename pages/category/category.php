<?php 
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "category.css";
    $javascript = "category.js";

    require_once("../header.php");

    // if (isset($_SESSION['Nombre_Completo']) && !empty($_SESSION['Nombre_Completo'])) {
    //     echo '<h1 class="title prussian">' . htmlspecialchars($_SESSION['Nombre_Completo']) . '</h1>';
    // } else {
    //     echo '<h1 class="title prussian">Usuario Invitado</h1>';
    // }
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
