<?php

//Donne l'acces a la BDD
include("./core/database/pdo.php");
$db = new Database();

//definition de $uc pour connaitre la page souhaitee
$uc = empty($_GET["uc"]) ? "login" : $_GET["uc"];

//redirection vers les sous-controleur ou pages
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
    case "order":
        include("./controllers/orderController.php");
        break;
}
