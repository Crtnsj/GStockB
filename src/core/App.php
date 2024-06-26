<?php
require_once("../src/core/Database.php");
require_once("../src/models/User.php");
require_once("../src/models/Stock.php");
require_once("../src/models/Order.php");

$orderDataAccess = new Order();
$stockDataAccess = new Stock();
$userDataAccess = new User();

//definition de $uc pour connaitre la page souhaitee
$uc = empty($_GET["uc"]) ? "login" : $_GET["uc"];

switch ($uc) {
    case "login":
        include "../src/views/user/v_login.php";
        break;
    case "home":
        if (isset($_SESSION["id_u"])) {
            $numberOfOrderInValidation = $orderDataAccess->getNumberOfOrderValidation();
            $numberOfOrder = $orderDataAccess->getNumberOfOrder();
            $numberOfStock = $stockDataAccess->getNumberOfStock();
            $numberOfUser = $userDataAccess->getNumberOfActivatedUser();
            $popularStocks = $stockDataAccess->getPopularStocks();
            $lowStocks = $stockDataAccess->getLowStocks(15);
            $lastOrders = $orderDataAccess->getLastOrders();
            $orderList = $orderDataAccess->handleFilter("id_co-DESC");
            include "../src/views/v_home.php";
        } else {
            setcookie("errorMessage", "Vous n'etes pas connecté", time() + (100000), "/");
            header("location: ./index.php");
        }
        break;


    case "user":
        if (isset($_SESSION["id_u"])) {
            if ($_SESSION["id_role"] == 1) {
                include "../src/controllers/userController.php";
            } else {
                setcookie("errorMessage", "Vous n'avez pas les droits suffisant", time() + (100000), "/");
                header("location: ./index.php?uc=home");
            }
        } else {
            setcookie("errorMessage", "Vous n'etes pas connecté", time() + (100000), "/");
            header("location: ./index.php");
        }
        break;
    case "stock":
        if (isset($_SESSION["id_u"])) {
            include "../src/controllers/stockController.php";
        } else {
            setcookie("errorMessage", "Vous n'etes pas connecté", time() + (100000), "/");
            header("location: ./index.php");
        }
        break;
    case "order":
        if (isset($_SESSION["id_u"])) {
            include "../src/controllers/orderController.php";
        } else {
            setcookie("errorMessage", "Vous n'etes pas connecté", time() + (100000), "/");
            header("location: ./index.php");
        }
        break;
    case "validLoginForm":
        //for login
        try {
            $login = $userDataAccess->login(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
            if ($login) {
                $userDataAccess->writeLog($_POST["email"] . " s'est connecté", 'loginSuccessLogs.log');
                header("location: ./index.php?uc=home");
            } else {
                $userDataAccess->writeLog($_POST["email"] . " a échoué la connexion", 'loginErrorLogs.log');
                setcookie("errorMessage", "Identifiants invalides", time() + (100000), "/");
                header("location: ./index.php");
            }
        } catch (Exception $e) {
            $userDataAccess->writeLog($e, 'userErrorLogs.log');
            setcookie("errorMessage", "Une erreur s'est produite", time() + (100000), "/");
        }
        break;
    case "disconnect":
        //remove session's data
        $_SESSION = array();
        //destruction of session
        session_destroy();
        //redirect to login page
        header("Location: index.php");
        break;
}
