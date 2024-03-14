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

    case "validOrder":
        include "./views/order/v_validOrder.php";
        include "./views/order/v_order.php";
        break;

    case "rejectOrder":
        include "./views/order/v_rejectOrder.php";
        include "./views/order/v_order.php";
        break;

    case "validForm":

        //for valid an order
        if (isset($_POST["valid"]) && isset($_POST["id"])) {
            if ($_SESSION['id_role'] < 3) {
                $orderStatut = $orderDataAccess->getStatut(htmlspecialchars($_POST["id"]));
                if ($orderStatut == "en_attente") {
                    $orderDetails = $orderDataAccess->getOrdersDetails(htmlspecialchars($_POST["id"]));
                    $type_co = $orderDataAccess->getTypeCo(htmlspecialchars($_POST["id"]));
                    for ($i = 0; $i < count($orderDetails); $i++) {
                        $stockDataAccess->updateQteOfStock($orderDetails[$i]->id_st, $orderDetails[$i]->quantite_details, $type_co);
                    }
                    $orderDataAccess->validOrder(htmlspecialchars($_POST["id"]));
                    header("location: index.php?uc=order&action=view");
                } else {
                    setcookie("errorMessage", "La commande n'est plus en attente", time() + (100000), "/");
                    header("location: index.php?uc=order&action=view");
                }
            } else {
                setcookie("errorMessage", "Vous n'avez pas les droits requis", time() + (100000), "/");
                header("location: index.php?uc=order&action=view");
            }
        }
        //for reject an order
        if (isset($_POST["reject"]) && isset($_POST["id"])) {
            if ($_SESSION['id_role'] < 3) {
                $orderStatut = $orderDataAccess->getStatut(htmlspecialchars($_POST["id"]));
                if ($orderStatut == "en_attente") {
                    $orderDataAccess->rejectOrder(htmlspecialchars($_POST["id"]));
                    header("location: index.php?uc=order&action=view");
                } else {
                    setcookie("errorMessage", "La commande n'est plus en attente", time() + (100000), "/");
                    header("location: index.php?uc=order&action=view");
                }
            } else {
                setcookie("errorMessage", "Vous n'avez pas les droits requis", time() + (100000), "/");
                header("location: index.php?uc=order&action=view");
            }
        }
        //for create an order 
        else if (isset($_POST["type_co"]) && $_POST["stock1"] && isset($_POST["qte1"]) && isset($_POST["numberOfStocks"])) {
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
        } else {
            setcookie("errorMessage", "Une erreur inconnue s'est produite", time() + (100000), "/");
            header("location: index.php?uc=order&action=view");
        }

        break;
}
