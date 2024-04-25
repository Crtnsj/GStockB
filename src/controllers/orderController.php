<?php


$action = $_GET["action"];

if (empty($_GET["filter"])) {
    $orders = $orderDataAccess->handleFilter("id_co-DESC");
} else {
    $filter = $_GET["filter"];
    $orders = $orderDataAccess->handleFilter($filter);
    $column = explode("-", $filter)[0];
    $order = explode("-", $filter)[1];
}

switch ($action) {
    case "view":
        include "../src/views/order/v_order.php";
        break;

    case "create":
        $stocks = $stockDataAccess->getStocksNames();
        include "../src/views/order/v_createOrder.php";
        include "../src/views/order/v_order.php";
        break;
    case "createLowStocks":
        $numberOfStock = $stockDataAccess->getNumberOfStock();
        include "../src/views/order/v_orderLowStocks.php";
        include "../src/views/order/v_order.php";
        break;

    case "viewDetails":
        $orderDetails = $orderDataAccess->getOrdersDetails(htmlspecialchars($_GET["id_co"]));
        include "../src/views/order/v_orderDetails.php";
        include "../src/views/order/v_order.php";
        break;

    case "validOrder":
        include "../src/views/order/v_validOrder.php";
        include "../src/views/order/v_order.php";
        break;

    case "rejectOrder":
        include "../src/views/order/v_rejectOrder.php";
        include "../src/views/order/v_order.php";
        break;

    case "validForm":

        //for valid an order
        if (isset($_POST["valid"]) && isset($_POST["id"])) {
            if ($_SESSION['id_role'] < 3) {
                $orderStatut = $orderDataAccess->getStatut(htmlspecialchars($_POST["id"]));
                if ($orderStatut == "en_attente") {
                    $orderDetails = $orderDataAccess->getOrdersDetails(htmlspecialchars($_POST["id"]));
                    $type_co = $orderDataAccess->getTypeCo(htmlspecialchars($_POST["id"]));
                    $stockUpdate = $stockDataAccess->updateQteOfStock($orderDetails, $type_co);
                    if ($stockUpdate) {
                        $orderDataAccess->validOrder(htmlspecialchars($_POST["id"]));
                        setcookie("successMessage", "La commande a bien été validée", time() + (100000), "/");
                    } else {
                        setcookie("errorMessage", "Le stock est insuffisant", time() + (100000), "/");
                    }
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
        if (isset($_POST["type_co"]) && $_POST["stock1"] && isset($_POST["qte1"]) && isset($_POST["numberOfStocks"])) {
            $actualDate = date('Y-m-d H:i:s');
            $numberOfStocks = htmlspecialchars($_POST["numberOfStocks"]); //nombre de stocks selectionnés
            $selectedStocks = array();

            //vérifie si un stock n'est pas rentré deux fois
            for ($i = 1; $i <= $numberOfStocks; $i++) {
                $stock[$i] = htmlspecialchars($_POST["stock" . $i]);
                $selectedStocks[] = $stock[$i];
            }

            if (!$stockDataAccess->compareIdenticalStock($selectedStocks)) {
                //tous les stocks sont uniques, continuer le processus ici

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
                header("location: index.php?uc=order&action=view");
            }
        }
        if (isset($_POST["nombreDeStocks"]) && isset($_POST["quantite"])) {
            $actualDate = date('Y-m-d H:i:s');
            if ($_POST["quantite"] > 0) {
                try {
                    $targetedStocks = $stockDataAccess->getLowStocks(intval($_POST["nombreDeStocks"]));
                    if ($targetedStocks) {
                        try {
                            //créer une commande
                            $orderDataAccess->createOrder('entrée', $actualDate, $_SESSION["id_u"]);
                            $targetedOrder = $orderDataAccess->getOrderByDate($actualDate, $_SESSION["id_u"]);
                            foreach ($targetedStocks as $stock) {
                                //creer un details de la commande
                                $orderDataAccess->createOrderDetails($targetedOrder, $stock->id_st, htmlspecialchars($_POST["quantite"]));
                            }
                            header("location: index.php?uc=order&action=view");
                        } catch (Exception $e) {
                            $stockDataAccess->writeLog("Nouvelle erreur inconnue : " . $e, 'unknownErrorLogs.log');
                        }
                    }
                } catch (Exception $e) {
                    setcookie("errorMessage", "Le minimum de stock est 0", time() + (100000), "/");
                    header("location: index.php?uc=order&action=view");
                }
            } else {
                setcookie("errorMessage", "La quantité ne peut être négative", time() + (100000), "/");
                header("location: index.php?uc=order&action=view");
            }
        }
        break;
}
