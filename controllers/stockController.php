<?php

$stockDataAccess = new stock();

$action = $_GET["action"];

switch ($action) {
    case "view":
        if (empty($_GET["filter"])) {
            $stocks = $stockDataAccess->handleFilter("id_st-ASC");
            include "./views/stock/v_stock.php";
            break;
        } else {
            $filter = $_GET["filter"];

            $stocks = $stockDataAccess->handleFilter($filter);
            $column = explode("-", $filter)[0];
            $order = explode("-", $filter)[1];
            include "./views/stock/v_stock.php";
        }
    case "update":
        if (isset($_GET["id_st"])) {
            $id = htmlspecialchars($_GET["id_st"]);
            $targetedStock  = $stockDataAccess->getStockByID($id);
            include("views/stock/v_updateStock.php");
        }
        break;
    case "create":
        include("views/stock/v_createStock.php");
        break;
    case "delete":
        if (isset($_GET["id_st"])) {
            $id = htmlspecialchars($_GET["id_st"]);
            include("views/stock/v_deleteStock.php");
        }
        break;
    case "validForm":
        if (isset($_POST["delete"]) && isset($_POST["id_st"])) {
            try {
                $stockDataAccess->deleteStock($_POST["id_st"]);
                header("location: ./index.php?uc=stock&action=view");
            } catch (Exception $e) {
                $_SESSION['messageBox'] = "errorStock"; //todo : handle messages
                echo "Le stock ne peut etre supprimer car il est concerné par des commandes";
            }
        } elseif (isset($_POST["id_st"], $_POST["nom_st"], $_POST["description_st"], $_POST["type_st"])) {
            $id_st = htmlspecialchars($_POST["id_st"]);
            $nom_st = htmlspecialchars($_POST["nom_st"]);
            $description_st = htmlspecialchars($_POST["description_st"]);
            $type_st = htmlspecialchars($_POST["type_st"]);
            try {
                $stockDataAccess->updateStock($id_st, $nom_st, $description_st, $type_st);
            } catch (Exception $e) {
                echo $e;
            }

            // header("location: ./index.php?uc=stock&action=view");
        } elseif (!isset($_POST["id_st"], $_POST["nom_st"], $_POST["description_st"], $_POST["quantite_st"], $_POST["type_st"])) {
            $nom_st = htmlspecialchars($_POST["nom_st"]);
            $description_st = htmlspecialchars($_POST["description_st"]);
            $quantite_st = htmlspecialchars($_POST["quantite_st"]);
            $type_st = htmlspecialchars($_POST["type_st"]);
            $stockDataAccess->createStock($nom_st, $description_st, $quantite_st, $type_st);
            header("location: ./index.php?uc=stock&action=view");
        }
        break;
}
