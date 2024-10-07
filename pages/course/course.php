<?php
    $titlename = "Foodemy";
    $stylename = "course.css";
    $javascript = "course.js";
   
    require_once("../header.php");
?>

<section id="bannerSection" class="back-prussian">
    <div class="container">
        <div class="row">
            <div class="col-6 text-container">
                <h5 class="title baby">Comida China fácil</h5>
                <p class="description baby">Aprende las mejores recetas de este enigmatico país, elaboradas de la manera más sencilla con ingredientes que tenemos en casa.</p>
                <p class="option mantis">Asiatico</p>
                <p class="detail baby">Manuel Chapa</p>
                <div class="rate-stars">
                    <h5 class="tiny-name baby">5</h5>
                    <img src="../resources/stars.png" alt="">
                </div>
                <div class="price-and-button">
                    <h4 class="title baby">$500</h4>
                    <button class="red-button agregar-carrito">Agregar al carrito</button>
                    <button class="green-button" onclick="window.location.href='contenido-curso.php';">Empezar curso</button>
                </div>
            </div>
            <div class="col-6 img-container">
                <img src="../resources/chefCourse.png" alt="">
            </div>
        </div>
    </div>
</section>

<section id="levelSection" class="back-eerie baby">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="headers">
                    <h3 class="title">Contenido</h3>
                    <h4 class="description">3 niveles</h4>
                </div>
                <div class="levels">
                    <div class="level">
                        <img src="../resources/dumplings.png" alt="">
                        <div>
                            <h4 class="name">Dumplings</h4>
                        </div>
                        <div class="compra"> 
                            <h4 class="big-name baby">$200</h4>
                            <div class="contenedor-boton-compra">
                                <button class="big-name boton-compra">Comprar nivel</button>
                            </div>
                        </div>
                    </div>
                    <div class="level">
                        <img src="../resources/rolls.png" alt="">
                        <div>
                            <h4 class="name">Rollos Primavera</h4>
                        </div>
                        <div class="compra"> 
                            <h4 class="big-name baby">$200</h4>
                            <div class="contenedor-boton-compra">
                                <button class="big-name boton-compra">Comprar nivel</button>
                            </div>
                        </div>
                    </div>
                    <div class="level">
                        <img src="../resources/rice.png" alt="">
                        <div>
                            <h4 class="name">Arroz con camarones</h4>
                        </div>
                        <div class="compra"> 
                            <h4 class="big-name baby">$200</h4>
                            <div class="contenedor-boton-compra">
                                <button class="big-name boton-compra">Comprar nivel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="commentSection" class="back-eerie baby">
    <div class="container">
        <div class="row">
            <div class="col-12 comments-body">
                <h3 class="title">Comentarios</h3>
                <div class="comments-container">
                    <div class="comment">
                        <img src="../resources/profilepic.png" alt="">
                        <div class="texts-container">
                            <div class="name-and-stars">
                                <h5 class="name">José manuel</h5>
                                <img src="../resources/stars.png" alt="">
                            </div>
                            <p class="description">Me gustó mucho, no era broma que puedes usar cualquier cosa jaja</p>
                        </div>
                        <!--Visible únicamente para los administradores-->
                        <!-- Botón de reporte -->
    <div class="contenedor-der">
        <button class="big-name boton-reporte" onclick="openReportMenu(this)">Reportar</button>
    </div>
    
    <!-- Formulario flotante para reporte -->
    <div class="report-menu" style="display:none;">
        <p>Selecciona un motivo:</p>
        <div>
        <label>
            <input type="radio" name="reportReason" value="spam"> Spam
        </label>
</div>
<div>
        <label>
            <input type="radio" name="reportReason" value="estafa"> Estafa
        </label>
</div>
<div>
        <label>
            <input type="radio" name="reportReason" value="odio"> Contenido que incita al odio
        </label>
</div>
<div>
        <label>
            <input type="radio" name="reportReason" value="acoso"> Acoso
        </label>
</div>
        <button onclick="submitReport(this)">Enviar</button>
        <button onclick="closeReportMenu(this)">Cancelar</button>
    </div>
                        <!------------------------------------------------>
                    </div>
                    <div class="comment">
                        <img src="../resources/profilepic.png" alt="">
                        <div class="texts-container">
                            <div class="name-and-stars">
                                <h5 class="name">Antonio Guevara</h5>
                                <img src="../resources/stars.png" alt="">
                            </div>
                            <p class="description">Está Genial</p>
                        </div>
                         <!--Visible únicamente para los administradores-->
                         <div class="contenedor-der">
                            <button class="big-name boton-reporte">Reportar</button>
                        </div>
                        <!------------------------------------------------>
                    </div>
                </div>
                <!-- HACER COMENTARIO -->
                <div class="contenedor-formulario">
                    <!-- Estrellas -->
                    <div class="stars">
                        <label for="rating">Calificación: </label>
                        <select id="rating" name="rating">
                            <option value="5">5 estrellas</option>
                            <option value="4">4 estrellas</option>
                            <option value="3">3 estrellas</option>
                            <option value="2">2 estrellas</option>
                            <option value="1">1 estrella</option>
                            <option value="0">0 estrellas</option>
                            <option value="6">Sin Calificación</option>
                        </select>
                    </div>
                    <!-- Formulario -->
                    <div class="comment-form">
                        <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Escribe tu comentario..."></textarea>
                        <button id="submitComment" class="big-name boton-enviar">Enviar comentario</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>