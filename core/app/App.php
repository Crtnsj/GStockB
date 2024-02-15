<?php

$uc = empty($_GET["uc"]) ? "login" : $_GET["uc"];

switch ($uc) {
    case "login":
        include('./controllers/loginController.php');
        break;
    case "home":
        include("vues/v_home.php");
        break;
    case "stock":
        include("./controllers/stockController.php");
        break;
}
