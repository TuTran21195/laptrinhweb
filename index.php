<?php
    include_once "includes/header.php";

    if(isset($_GET['page'])){
        switch ($_GET['page']){
            case "home":
                include_once "views/home.html";
                break;
            case "about":
                include_once "views/about.html";
                break;
            case "menu":
                include_once "views/menu.html";
                break;
            default:
                # code
                break; 
        }
    } else{
        include_once "views/home.html";
    }

    include_once "includes/footer.php";
?>