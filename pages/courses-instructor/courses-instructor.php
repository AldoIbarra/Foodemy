<?php
    require("../../config/sessionVerif.php");
    $titlename = "Mis Cursos - Instructor";
    $stylename = "courses-instructor.css";
    $javascript = "courses-instructor.js";
   
    require_once("../header.php");

    if($_SESSION['Rol'] == 'Instructor'){
        require_once("../teacherNav.php");
    }else{
        header("Location:../dashboard/dashboard.php");
    }
?>

<section id="myCoursesSection" class="back-eerie">
    <div class="container">
        <h1 class="title baby">Mis <span class="poppy">cursos</span></h1>
        <div class="row">
            <!-- Curso 1 -->
            <div class="col-4 course">
                <img src="../resources/Chef2.jpg" alt="Imagen del curso">
                <h5 class="tiny-name baby">Tacos del norte de México</h5>
                <p class="detail baby">10 estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración:</h5>
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/half-star.svg" alt="Media estrella">
                </div>
                <button class="blue-button">Ver detalles</button>
                <button class="red-button">Eliminar curso</button>
            </div>
            <!-- Curso 2 -->
            <div class="col-4 course">
                <img src="../resources/chef 3.jpg" alt="Imagen del curso">
                <h5 class="tiny-name baby">Comida china fácil</h5>
                <p class="detail baby">8 estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración:</h5>
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                </div>
                <button class="blue-button" onclick="window.location.href='detallecurso.php';">Ver detalles</button>
                <button class="red-button">Eliminar curso</button>
            </div>
            <!-- Curso 3 -->
            <div class="col-4 course">
                <img src="../resources/Chef1.jpeg" alt="Imagen del curso">
                <h5 class="tiny-name baby">Comida típica brasileña</h5>
                <p class="detail baby">54 estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración: </h5>
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                </div>
                <button class="blue-button">Ver detalles</button>
                <button class="red-button">Eliminar curso</button>
            </div>
             <!-- Curso 4 -->
             <div class="col-4 course">
                <img src="../resources/chef11.jpg" alt="Imagen del curso">
                <h5 class="tiny-name baby">Repostería básica</h5>
                <p class="detail baby">20 estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración:</h5>
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/half-star.svg" alt="Media estrella">
                </div>
                <button class="blue-button">Ver detalles</button>
                <button class="red-button">Eliminar curso</button>
            </div>
            <!-- Curso 5 -->
            <div class="col-4 course">
                <img src="../resources/chef10.jpeg" alt="Imagen del curso">
                <h5 class="tiny-name baby">Comida japonesa</h5>
                <p class="detail baby">2 estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración:</h5> 
                    <img src="../resources/star.svg" alt="Estrella">
                </div>
                <button class="blue-button">Ver detalles</button>
                <button class="red-button">Eliminar curso</button>
            </div>
            <!-- Curso 6 -->
            <div class="col-4 course">
                <img src="../resources/chef12.jpg" alt="Imagen del curso">
                <h5 class="tiny-name baby">La comida del mar</h5>
                <p class="detail baby">12 estudiantes inscritos</p>
                <div class="stats">
                    <h5 class="tiny-name baby">Valoración: </h5>
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                    <img src="../resources/star.svg" alt="Estrella">
                </div>
                <button class="blue-button">Ver detalles</button>
                <button class="red-button">Eliminar curso</button>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
