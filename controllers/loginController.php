<?php
//Donne l'acces a la BDD
include("../core/database/pdo.php");
$db = new Database();
//definition de $action pour connaitre l'action souhaitee
$action = empty($_GET["action"]) ? "signin" : $_GET["action"];

//redirection vers les vues ou services
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
