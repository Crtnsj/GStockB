<?php
$action = empty($_GET["action"]) ? "view" : $_GET["action"];
include("../core/database/pdo.php");
$db = new Database();
include("./models/Order.php");
include("./models/Stock.php");
$stockAccess = new Stock();
$orderAccess = new Order();
$orders = $orderAccess->getOrders();
$actualDate = date('Y-m-d H:i:s');

switch ($action) {
    case "view":
        include('./vues/v_order.php');
        break;
    case "create":
        $stocks = $stockAccess->getStocksNames();
        include("./vues/v_createOrder.php");
        break;
    case "validForm":
        $id = htmlspecialchars($_POST["id_co"]);
        $type_co = htmlspecialchars($_POST["type_co"]);
        $numberOfStocks = htmlspecialchars($_POST["numberOfStocks"]);
        $stock = array(); // Initialisation du tableau $stock
        if (empty($_POST["id_co"])) {
            $date_co = $actualDate;
            $orderAccess->createOrder($type_co, $date_co);
            $id = $orderAccess->getOrderByDate($date_co);

            for ($i = 1; $i <= $numberOfStocks; $i++) {
                $stock[$i] = htmlspecialchars($_POST["stock" . $i]);
                $translateID_st = $stockAccess->translateNameToID($stock[$i]);
                $qte[$i] = htmlspecialchars($_POST["qte" . $i]);
                $orderAccess->createOrderDetails($id[0]->id_co, $translateID_st[0]->id_st, $qte[$i]);
            }

            header("location: index.php?uc=order&action=view");
        }

        break;
    case "delete":
        echo "hello";
        if (isset($_GET["id_co"])) {
            $id = htmlspecialchars($_GET["id_co"]);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $orderAccess->deleteOrder($id);
            header("location: index.php?uc=order&action=view");
        }
        include("vues/v_deleteOrder.php");
        break;
}
