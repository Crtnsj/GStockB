<?php

require_once "./models/User.php";
$user = new User();

$action = $_GET["action"];

switch ($action) {
    default:
        include "./views/v_error.php";
        break;
    case "validForm":
        $user->login(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
        break;
}
