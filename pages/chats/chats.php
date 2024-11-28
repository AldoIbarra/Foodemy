<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "chats.css";
    $javascript = "chats.js";
   
    require_once("../header.php");

    switch ($_SESSION['Rol']) {
        case 'Estudiante':
            require_once("../studentNav.php");
            break;
        case 'Instructor':
            require_once("../teacherNav.php");
            break;
        default:
            header("Location:../login/login.php");
            require_once("../emptyNav.php");
            break;
    }
?>

<section id="chats-body" class="back-eerie">
    <div class="container">
        <div class="row">
            <div class="col-4 contact-list back-eerie" id="contact-list">
            </div>
            <div class="col-8 back-prussian baby chat">
                <div class="name-container">
                    <img id="chatimg" src="" alt="">
                    <h3 id="chatName"></h3>
                </div>
                <div class="messages">
                    <div class="message me">
                        <p class="message-content">Hola Instructor, ¿la salsa de almeja tiene que ser de la que sale en el video?</p>
                        <img src="../resources/profilepic.png" alt="">
                    </div>
                    <div class="message you">
                        <img src="../resources/profilepic.png" alt="">
                        <p class="message-content">Hola, puede ser de cualquiera</p>
                    </div>
                    <div class="message me">
                        <p class="message-content">Gracias</p>
                        <img src="../resources/profilepic.png" alt="">
                    </div>
                </div>
                <div class="message-bar">
                    <textarea class="baby" name="" id="messageContainer"></textarea>
                    <button onclick="sendMsg();">
                        <img src="../resources/send.png" alt="">
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>


<?php include("../footer.php"); ?>