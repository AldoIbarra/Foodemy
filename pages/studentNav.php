
<?php
require("../../config/sessionVerif.php");
?>

    <nav class="back-eerie">
        <a href="../dashboard/dashboard.php" class="title poppy">Foodemy</a>
        <button id="category-button">
            <h4 class="baby option">Cursos</h4>
            <img src="../resources/dropdown.svg" alt="">
        </button>
        <div id="searchBarContainer">
            <button>
                <img src="../resources/magnifying-glass-white.svg" alt="">
            </button>
            <input type="text" name="search-bar" id="search-bar" placeholder="Busca algún curso...">
        </div>
        <div class="col-3 cart-user">
            <a class="cart-icon" href="../chats/chats.php"> 
                <img src="../resources/chat.svg" alt="">
            </a>
            <div class="user-menu">
                <?php
                    if($_SESSION){
                        echo '<img src="data:image/jpeg;base64,'.$_SESSION['Foto_Perfil'].'" alt="profile" width="50px" height="50px">';
                        
                    }else{
                        echo '<img src="../whiteCart.svg" alt="profile">';
                    }
                ?>
                <div class="user-dropdown">
                    <p class="dropdown-item" id="user_name"></p>
                    <a class="dropdown-item" href="../myProfile/profile.php">Perfil</a>
                    <a class="dropdown-item" href="../kardex/kardex.php">Kardex</a>
                    <a class="dropdown-item" href="../../config/cerrarSesion.php">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </nav>