<?php 
    $titlename = "Foodemy";
    $stylename = "kardex.css";
    $javascript = "kardex.js";

    require_once("../header.php");
?>

<section id="bannerSection" class="back-prussian">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-4 img-container full-height-img">
                    <img src="../resources/Chef6.png" alt="Chef grande">
                </div>
                <div class="col-7 text-container">
                    <h1 class="title baby">Kardex</h1>
                    <div class="filtros">
  <div class="filtros-row">
    <div>
      <label for="fecha-inscripcion" class="option baby">Rango de fechas de inscripción:</label>
      <input type="date" id="fecha-inscripcion-inicio">
      <label class="option baby">a:</label>
      <input type="date" id="fecha-inscripcion-fin">
    </div>
    <div>
      <label for="categoria" class="option baby">Categoría:</label>
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
    </div>
  </div>
  
  <div class="filtros-row">
    <div>
      <label for="estado" class="option baby">Estado del curso:</label>
      <select id="estado">
        <option value="todos">Todos</option>
        <option value="terminados">Solo cursos terminados</option>
      </select>
    </div>
    <div>
      <label for="activo" class="option baby">Cursos activos:</label>
      <select id="activo">
        <option value="todos">Todos</option>
        <option value="activos">Solo cursos activos</option>
      </select>
    </div>
  </div>
  
  <button id="filtrar">Filtrar</button>
</div>
    
                    <div class="kardex">
                        <!-- Los resultados del Kardex se cargarán aquí -->
                    </div>
                </div>

        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
