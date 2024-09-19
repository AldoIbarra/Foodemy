<?php 
    $titlename = "Foodemy";
    $stylename = "sales.css";
    $javascript = "sales.js";

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
                        <option value="Cocina Saludable">Cocina Saludable</option>
                        <option value="Cocina Internacional">Cocina Internacional</option>
                        <option value="Repostería y Pastelería">Repostería y Pastelería</option>
                        <option value="Cocina Vegetariana y Vegana">Cocina Vegetariana y Vegana</option>
                        <option value="Técnicas de Cocina Básicas">Técnicas de Cocina Básicas</option>
                        <option value="Cocina de Temporada">Cocina de Temporada</option>
                        <option value="Platos Rápidos">Platos Rápidos</option>
                    </select>

                    <label for="activo" class="option eerie">Cursos activos:</label>
                        <select id="activo">
                            <option value="todos">Todos</option>
                            <option value="activos">Solo cursos activos</option>
                        </select>

                    <label for="tipo-reporte" class="option eerie">Tipo de Reporte:</label>
                        <select id="tipo-reporte">
                            <option value="general">General</option>
                            <option value="detallado">Detallado</option>
                        </select>

                    </div>
                          <button class="red-button" id="filtrar-ventas">Filtrar</button>
                    </div>
                </div>

                <div class="tablas">
                    <table id="tabla-ventas">
                        <thead>
                            <tr id="cabecera-tabla-ventas">

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div id="tabla-cursos">
                    <caption></caption>
                </div>

                <div id="resumen-ventas">
                  <!-- Resumen de ingresos por forma de pago -->
                </div>

            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
