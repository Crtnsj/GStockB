<?php
require_once("./core/Database.php");
require_once("./models/User.php");
require_once("./models/Stock.php");
require_once("./models/Order.php");

$orderDataAccess = new Order();
$stockDataAccess = new Stock();
$userDataAccess = new User();

//definition de $uc pour connaitre la page souhaitee
$uc = empty($_GET["uc"]) ? "login" : $_GET["uc"];

switch ($uc) {
    case "login":
        include "./views/user/v_login.php";
        break;
    case "home":
        if (isset($_SESSION["id_u"])) {
            $numberOfOrderInValidation = $orderDataAccess->getNumberOfOrderValidation();
            $numberOfOrder = $orderDataAccess->getNumberOfOrder();
            $numberOfStock = $stockDataAccess->getNumberOfStock();
            $numberOfUser = $userDataAccess->getNumberOfUser();
            $popularStocks = $stockDataAccess->getPopularStocks();
            $lowStocks = $stockDataAccess->getLowStocks();
            $lastOrders = $orderDataAccess->getLastOrders();
            $orderList = $orderDataAccess->handleFilter("id_co-ASC");
            include "./views/v_home.php";
        } else {
            setcookie("errorMessage", "loginError", time() + (100000), "/");
            header("location: ./index.php");
        }
        break;


    case "user":
        include "./controllers/userController.php";
        break;
    case "stock":
        if (isset($_SESSION["id_u"])) {
            include "./controllers/stockController.php";
        } else {
            $_SESSION["messageBox"] = "loginError"; //todo : handle messages
        }
        break;
    case "order":
        if (isset($_SESSION["id_u"])) {
            include "./controllers/orderController.php";
        } else {
            $_SESSION["messageBox"] = "loginError"; //todo : handle messages
        }
        break;
}
