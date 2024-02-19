<?php
require_once("./core/Database.php");
require_once("./models/User.php");
require_once("./models/Stock.php");

//definition de $uc pour connaitre la page souhaitee
$uc = empty($_GET["uc"]) ? "login" : $_GET["uc"];

switch ($uc) {
    case "login":
        include "./views/user/v_login.php";
        break;
    case "home":
        if (isset($_SESSION["id_u"])) {
            include "./views/v_home.php";
        } else {
            $_SESSION["messageBox"] = "loginError";
        }
        break;
    case "user":
        include "./controllers/userController.php";
        break;
    case "stock":
        include "./controllers/stockController.php";
        break;
}
