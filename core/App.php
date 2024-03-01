<?php
require_once("./core/Database.php");
require_once("./models/User.php");
require_once("./models/Stock.php");
require_once("./models/Order.php");

//definition de $uc pour connaitre la page souhaitee
$uc = empty($_GET["uc"]) ? "login" : $_GET["uc"];

switch ($uc) {
    case "login":
        include "./views/user/v_login.php";
        break;
    case "home":
        if (isset($_SESSION["id_u"])) {
            include "./views/v_navBar.php";
            include "./views/v_home.php";
        } else {
            $_SESSION["messageBox"] = "loginError"; //todo : handle messages
        }
        break;
    case "user":
        include "./controllers/userController.php";
        break;
    case "stock":
        if (isset($_SESSION["id_u"])) {
            include "./views/v_navBar.php";
            include "./controllers/stockController.php";
        } else {
            $_SESSION["messageBox"] = "loginError"; //todo : handle messages
        }
        break;
    case "order":
        if (isset($_SESSION["id_u"])) {
            include "./views/v_navBar.php";
            include "./controllers/orderController.php";
        } else {
            $_SESSION["messageBox"] = "loginError"; //todo : handle messages
        }
        break;
}
