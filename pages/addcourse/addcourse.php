<?php
    $titlename = "Foodemy";
    $stylename = "addcourse.css";
    $javascript = "addcourse.js";
   
    require_once("../header.php");
?>

<section id="addCourseBody" class="back-prussian">
    <div class="container">
        <div class="row">
            <div class="col-6 course-info">
                <h1 class="big-name baby">Agregar Curso</h1>
                <form action="">
                    <input type="text" name="Title" id="title" placeholder="Titulo" class="title">
                    <textarea name="" id="" placeholder="Descripción..."></textarea>
                    <div class="file-zone">
                        <label for="" class="description baby">Imagen del curso</label>
                        <input type="file" id="" name="" class="description baby">
                    </div>
                </form>
                <div class="button-container">
                    <button class="red-button">Guardar curso</button>
                </div>
            </div>
            <div class="col-6 level-info">
                <h1 class="title baby">Agregar niveles</h1>
                <div id="addlevel">
                    <form action="" class="level-info">
                        <div class="title-price-container">
                            <input type="text" name="" id="" class="description" placeholder="Titulo del nivel">
                            <input type="number" name="" id="" class="description" placeholder="Precio">
                        </div>
                        <textarea name="" id="" placeholder="Descripción..."></textarea>
                        <div class="file-zone">
                            <label for="" class="description baby">Video del nivel</label>
                            <input type="file" id="" name="">
                        </div>
                        <div class="file-zone">
                            <label for="" class="description baby">Archivo relacionado</label>
                            <input type="file" id="" name="">
                        </div>
                    </form>
                    <div class="addnewlevelcontainer">
                        <button class="red-button" id="addNNewLevel">Agegar nivel</button>
                    </div>
                </div>
                <div class="add-level-container">
                    <button class="baby back-eerie big-name" id="show-form">+</button>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include("../footer.php"); ?>