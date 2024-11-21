<?php
    require("../../config/sessionVerif.php");
    $titlename = "Desbloquear Usuarios - Admin";
    $stylename = "unlock.css";
    $javascript = "unlock.js";
   
    require_once("../header.php");

    if($_SESSION['Rol'] == 'Administrador'){
        require_once("../teacherNav.php");
    }else{
        header("Location:../dashboard/dashboard.php");
    }
?>

<section id="unlockSection" class="back-eerie">
    <div class="container">
        <h1 class="title baby">Desbloquear <span class="poppy">Usuarios</span></h1>
        <div class="row">
            <!-- Usuario 1 -->
            <div class="col-4 user-blocked">
                <img src="../resources/user1.jpeg" alt="Juan Pérez" class="profile-pic">
                <h5 class="tiny-name baby">Juan Pérez</h5>
                <p class="detail baby">Usuario bloqueado por mala conducta </p>
                <button class="unlock-button">Desbloquear</button>
            </div>
            <!-- Usuario 2 -->
            <div class="col-4 user-blocked">
                <img src="../resources/user2.jpg" alt="María López" class="profile-pic">
                <h5 class="tiny-name baby">María López</h5>
                <p class="detail baby">Usuario bloqueado por spam </p>
                <button class="unlock-button">Desbloquear</button>
            </div>
            <!-- Usuario 3 -->
            <div class="col-4 user-blocked">
                <img src="../resources/user3.jpg" alt="Carlos García" class="profile-pic">
                <h5 class="tiny-name baby">Carlos García</h5>
                <p class="detail baby">Usuario bloqueado por mala conducta </p>
                <button class="unlock-button">Desbloquear</button>
            </div>
            <!-- Usuario 4 -->
            <div class="col-4 user-blocked">
                <img src="../resources/user4.jpeg" alt="Ross Lynch" class="profile-pic">
                <h5 class="tiny-name baby">Carlos García</h5>
                <p class="detail baby">Usuario bloqueado por mala conducta </p>
                <button class="unlock-button">Desbloquear</button>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>
