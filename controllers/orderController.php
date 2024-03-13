<?php

$action = $_GET["action"];

if (empty($_GET["filter"])) {
    $orders = $orderDataAccess->handleFilter("id_co-ASC");
} else {
    $filter = $_GET["filter"];

    $orders = $orderDataAccess->handleFilter($filter);
    $column = explode("-", $filter)[0];
    $order = explode("-", $filter)[1];
}

switch ($action) {
    case "view":
        include "./views/order/v_order.php";
        break;


    case "create":
        $stocks = $stockDataAccess->getStocksNames();
        include "./views/order/v_createOrder.php";
        include "./views/order/v_order.php";
        break;


    case "viewDetails":
        $orderDetails = $orderDataAccess->getOrdersDetails(htmlspecialchars($_GET["id_co"]));
        include "./views/order/v_orderDetails.php";
        include "./views/order/v_order.php";
        break;


    case "validForm":
        $numberOfStocks = htmlspecialchars($_POST["numberOfStocks"]);
        $selectedStocks = array();

        for ($i = 1; $i <= $numberOfStocks; $i++) {
            $stock[$i] = htmlspecialchars($_POST["stock" . $i]);
            $selectedStocks[] = $stock[$i];

            $qte[$i] = htmlspecialchars($_POST["qte" . $i]);
            $translateID_st = $stockDataAccess->translateNameToID($stock[$i]);
            $qteAvaible = $stockDataAccess->getQteOfStock($translateID_st);
        }

        if (!$stockDataAccess->compareIdenticalStock($selectedStocks)) {
            //Tous les stocks sont uniques, continuer le processus ici
            $actualDate = date('Y-m-d H:i:s');
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
                $orderDataAccess->createOrderDetails($targetedOrder, $translateID_st, $qte[$i]);
            }
            header("location: index.php?uc=order&action=view");
        } else {
            setcookie("errorMessage", "Vous ne pouvez pas créer une commande qui contient deux fois le meme stock", time() + (100000), "/");
            header("location: index.php?uc=order&action=create");
        }

        break;
    case "validOrder":
        if ($_SESSION['id_role'] < 3) {
            $orderStatut = $orderDataAccess->getStatut(htmlspecialchars($_GET["id_co"]));
            if ($orderStatut == "en_attente") {
                $orderDetails = $orderDataAccess->getOrdersDetails(htmlspecialchars($_GET["id_co"]));
                $type_co = $orderDataAccess->getTypeCo(htmlspecialchars($_GET["id_co"]));
                for ($i = 0; $i < count($orderDetails); $i++) {
                    $stockDataAccess->updateQteOfStock($orderDetails[$i]->id_st, $orderDetails[$i]->quantite_details, $type_co);
                }
                $orderDataAccess->validOrder(htmlspecialchars($_GET["id_co"]));
                header("location: index.php?uc=order&action=view");
            } else {
                setcookie("errorMessage", "La commande est déjà validée", time() + (100000), "/");
                header("location: index.php?uc=order&action=view");
            }
        };

        break;
}
