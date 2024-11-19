<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "addcourse.css";
    $javascript = "addcourse.js";
   
    require_once("../header.php");
   
    if($_SESSION['Rol'] == 'Instructor'){
        require_once("../teacherNav.php");
    }else{
        header("Location:../dashboard/dashboard.php");
    }
?>

<section id="addCourseBody" class="back-prussian">
    <div class="container">
        <div class="row">
            <div class="col-6 course-info">
                <h1 class="big-name baby">Agregar Curso</h1>
                <form id="course-form" enctype="multipart/form-data">
                    <input type="text" name="Title" id="course-title" placeholder="Titulo" class="title">
                    <textarea name="Description" id="course-desc" placeholder="Descripción..."></textarea>

                    <br>

                    <div>
                        <label for="course-category" class="description baby">Categoría del curso</label>
                        <select id="course-category" class="description" required>
                            <option value="">Seleccione una categoría</option>
                        </select>
                    </div>
                    <br>

                    <div class="file-zone">
                        <label for="" class="description baby">Imagen del curso</label>
                        <input type="file" id="course-img" name="course-img" class="description baby" accept="image/jpeg,image/png,image/gif,image/jpg">
                        
                    </div>
                    <br>
                    
                    <!-- Input para el precio del curso -->
                    <div class="price-container">
                        <input type="number" name="course-price" id="course-price" class="description" placeholder="Precio del curso en general">
                    </div>
                </form>
                <div class="button-container">
                    <button class="red-button" id="save-course">Guardar curso</button>
                </div>
            </div>
            <div class="col-6 level-info">
                <h1 class="title baby">Agregar niveles</h1>
                <!-- Select para escoger la cantidad de niveles -->
                <div>
                    <label for="level-count" class="baby">Cantidad de niveles</label>
                    <select id="level-count" class="description">
                        <option value="0">Selecciona cantidad de niveles</option>
                        <option value="1">1 nivel</option>
                        <option value="2">2 niveles</option>
                        <option value="3">3 niveles</option>
                        <option value="4">4 niveles</option>
                        <option value="5">5 niveles</option>
                        <option value="6">6 niveles</option>
                        <option value="7">7 niveles</option>
                        <option value="8">8 niveles</option>
                    </select>
                </div>

                <div id="addlevel">
                    <!-- Formulario dinámico para niveles -->
                    <div id="level-forms-container">
                        <!-- Los formularios de niveles se generarán aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
