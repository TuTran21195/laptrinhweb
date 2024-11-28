<?php
    include_once "includes/header.php";

    if(isset($_GET['page'])){
        switch ($_GET['page']){
            case "home":
                include_once "views/home.php";
                break;
            case "about":
                include_once "views/about.html";
                break;
            case "menu":
                include_once "views/menu.php";
                break;
            default:
                # code
                break; 
        }
    } else{
        include_once "views/home.php";
    }

    include_once "includes/footer.php";
?>