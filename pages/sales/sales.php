<?php 
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "sales.css";
    $javascript = "sales.js";

    require_once("../header.php");

    if($_SESSION && $_SESSION['Rol'] == 'Instructor'){
        require_once("../teacherNav.php");
    }else{
        header("Location:../login/login.php");
        require_once("../emptyNav.php");
    }
?>

<section id="bannerSection" class="back-prussian">
    <div class="container-fluid">
        <div class="row no-gutters">
            <!-- Comentada la imagen de fondo
            <div class="col-4 img-container full-height-img">
                <img src="https://wallpapercave.com/wp/wp1882342.jpg" alt="Chef grande">
            </div> -->
            <div class="col-12 text-container"> <!-- Ajustar a col-12 para ocupar todo el ancho -->
                <h1 class="title baby">Ventas</h1>
                
                <div class="filtros">
                <div class="filtros-row">
                <!-- Contenedor para las fechas -->
                <div class="filtros-fechas">
                    <label for="fecha-inscripcion" class="option eerie">Rango de fechas de creación de los cursos:</label>
                    <input type="date" id="fecha-inscripcion-inicio" class="first-date">
                    <label class="option eerie a">a:</label>
                    <input type="date" id="fecha-inscripcion-fin">
                </div>

                <!-- Contenedor para los selects -->
                <div class="filtros-selects">
                    <label for="categoria" class="option eerie">Categoría:</label>
                    <select id="number-of-categories" required>
                        <option value="todas">Todas</option>
                    </select>

                    </div>
                          <button class="red-button" onclick="getSalesReport();">Filtrar</button>
                    </div>
                </div>

                <div class="tablas">
                    <table id="tabla-ventas">
                        
                    </table>
                </div>

                <!-- <div id="tabla-cursos">
                    <caption></caption>
                </div>

                <div id="resumen-ventas">
                  Resumen de ingresos por forma de pago
                </div> -->

            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
