<?php 
    $titlename = "Foodemy";
    $stylename = "report.css";
    $javascript = "report.js";

    require_once("../header.php");
?>

<section id="bannerSection" class="back-prussian">
    <div class="container-fluid">
        <div class="row no-gutters">
            <!-- Comentada la imagen de fondo
            <div class="col-4 img-container full-height-img">
                <img src="https://wallpapercave.com/wp/wp1882342.jpg" alt="Chef grande">
            </div> -->
            <div class="col-12 text-container"> <!-- Ajustar a col-12 para ocupar todo el ancho -->
                <h1 class="title baby">Reportes</h1>
                
                <div class="filtros">
                <div class="filtros-row">
                <br><br>
                <label class="option baby" for="tipo-usuario">Seleccionar tipo de usuario:</label>
        <select id="tipo-usuario">
            <option value="instructor">Instructor</option>
            <option value="estudiante">Estudiante</option>
        </select>

        <button class="red-button" id="generar-reporte">Generar Reporte</button>

        <div class="tablas">
            <table id="tabla-reporte">
                <thead>
                    <tr id="cabecera-tabla">
                        <!-- Aquí se generarán dinámicamente las columnas -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se generarán dinámicamente las filas -->
                </tbody>
            </table>
        </div>

            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
