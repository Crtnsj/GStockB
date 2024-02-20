<?php

$orderDataAccess = new Order();
$stockDataAccess = new Stock();

$action = $_GET["action"];

switch ($action) {
    case "view":
        $orders = $orderDataAccess->getOrders();
        include "./views/order/v_order.php";
        break;
    case "create":
        $stocks = $stockDataAccess->getStocksNames();
        include "./views/order/v_createOrder.php";
        break;
    case "validForm":
        $numberOfStocks = htmlspecialchars($_POST["numberOfStocks"]);
        $selectedStocks = array();
        for ($i = 1; $i <= $numberOfStocks; $i++) {
            $stock[$i] = htmlspecialchars($_POST["stock" . $i]);
            $selectedStocks[] = $stock[$i];
        }
        if (!$stockDataAccess->compareIdenticalStock($selectedStocks)) {
            echo "hello";
            //Tous les stocks sont uniques, continuer le processus ici
            $orderDataAccess->createOrder(htmlspecialchars($_POST["type_co"]), $actualDate, $_SESSION["id_u"]);
            $targetedOrder = $orderDataAccess->getOrderByDate($actualDate, $_SESSION["id_u"]);
            for ($i = 1; $i <= $numberOfStocks; $i++) {
                //recupere le nom du stock
                $stock[$i] = htmlspecialchars($_POST["stock" . $i]);
                // //recupere la quantite
                $qte[$i] = htmlspecialchars($_POST["qte" . $i]);
                // //traduit le nom du stock par son id
                $translateID_st = $stockDataAccess->translateNameToID($stock[$i]);
                //creer un details de la commande
                $orderDataAccess->createOrderDetails($targetedOrder[0]->id_co, $translateID_st[0]->id_st, $qte[$i]);
            }
            header("location: index.php?uc=order&action=view");
        } else {
            $_SESSION['messageBox'] = "errorOrder"; //todo : handle messages
        }

        break;
}
