<?php

$stockDataAccess = new stock();

$action = $_GET["action"];

switch ($action) {
    case "view":
        $stocks = $stockDataAccess->getStocks();
        include "./views/stock/v_stock.php";
        break;
    case "update":
        if (isset($_GET["id_st"])) {
            $id = htmlspecialchars($_GET["id_st"]);
            $targetedStock  = $stockDataAccess->getStockByID($id);
            include("views/stock/v_updateStock.php");
        }
        break;
    case "delete":
        if (isset($_GET["id_st"])) {
            $id = htmlspecialchars($_GET["id_st"]);
            include("views/stock/v_deleteStock.php");
        }
        break;
    case "validForm":
        if (isset($_POST["delete"])) {
            try {
                $stockDataAccess->deleteStock($_POST["id_st"]);
                header("location: ./index.php?uc=stock&action=view");
            } catch (Exception $e) {
                $_SESSION['messageBox'] = "errorStock"; //todo : handle messages
                echo "Le stock ne peut etre supprimer car il est concerné par des commandes";
            }
        }
        break;
}
