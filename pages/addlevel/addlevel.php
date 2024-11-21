<?php
    require("../../config/sessionVerif.php");
    $titlename = "Foodemy";
    $stylename = "addlevel.css";
    $javascript = "addlevel.js";
   
    require_once("../header.php");
   
    if($_SESSION['Rol'] == 'Instructor'){
        require_once("../teacherNav.php");
    }else{
        header("Location:../dashboard/dashboard.php");
    }
?>
    <a href="">aaaaaaaaa</a>


<?php include("../footer.php"); ?>