<?php
require("../../config/sessionVerif.php");
?>

<nav class="back-eerie">
    <h1 class="title poppy">Foodemy</h1>
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
        <a class="cart-icon" href="../userCart/userCart.php">
            <img src="../resources/whiteCart.svg" alt="">
        </a>
        <div class="user-menu">
        <?php
                    if($_SESSION){
                        echo '<figure><img src="data:image/jpeg;base64,'.$_SESSION['Foto_Perfil'].'" alt="profile" width="50px" height="50px"></figure>';
                        
                    }else{
                        echo '<figure><img src="../whiteCart.svg" alt="profile"></figure>';
                    }
                ?>
            <div class="user-dropdown">
                <p class="dropdown-item" id="user_name"></p>
                <a class="dropdown-item" href="../myProfile/myProfile.php">Perfil</a>
                <a class="dropdown-item" href="../unlock-admin/unlock-admin.php">Usuarios</a>
                <a class="dropdown-item" href="../category/category.php">Categorias</a>
                <a class="dropdown-item" href="../report/report.php">Reportes</a>
                <a class="dropdown-item" href="../../config/cerrarSesion.php">Cerrar sesión</a>
            </div>
        </div>
    </div>
</nav>