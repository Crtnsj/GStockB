<?php
$action = empty($_GET["action"]) ? "signin" : $_GET["action"];

switch ($action) {
    case "signin":
        include('./vues/v_signin.php');
        break;
    case "signup":
        include("vues/v_signup.php");
        break;
    case "disconnect":
        include("services/disconnect.php");
        break;
}
