<?php
    $titlename = "Foodemy";
    $stylename = "chats.css";
    $javascript = "chats.js";
   
    require_once("../header.php");
?>

<section id="chats-body" class="back-eerie">
    <div class="container">
        <div class="row">
            <div class="col-4 contact-list back-eerie baby">
                <div class="contact">
                    <img src="../resources/profilepic.png" alt="">
                    <h4>Eliud Ramirez</h4>
                </div>
                <hr>
                <div class="contact">
                    <img src="../resources/profilepic.png" alt="">
                    <h4>Manuel Chapa</h4>
                </div>
            </div>
            <div class="col-8 back-prussian baby chat">
                <div class="name-container">
                    <h3>Eliud Ramirez</h3>
                </div>
                <div class="messages">
                    <div class="message">
                        <p class="message-content">Hola Instructor, ¿la salsa de almeja tiene que ser de la que sale en el video?</p>
                        <img src="../resources/profilepic.png" alt="">
                    </div>
                    <div class="message">
                        <img src="../resources/profilepic.png" alt="">
                        <p class="message-content">Hola, puede ser de cualquiera</p>
                    </div>
                    <div class="message">
                        <p class="message-content">Gracias</p>
                        <img src="../resources/profilepic.png" alt="">
                    </div>
                </div>
                <div class="message-bar">
                    <input type="text" class="baby">
                    <button>
                        <img src="../resources/send.png" alt="">
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>


<?php include("../footer.php"); ?>