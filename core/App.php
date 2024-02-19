<?php
require_once("./core/Database.php");
//definition de $uc pour connaitre la page souhaitee
$uc = empty($_GET["uc"]) ? "login" : $_GET["uc"];

switch ($uc) {
    case "login":
        include "./views/user/login.php";
        break;
    case "user":
        include "./controllers/userController.php";
        break;
}
