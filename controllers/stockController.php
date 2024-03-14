<?php

$action = $_GET["action"];

if (empty($_GET["filter"])) {
    $stocks = $stockDataAccess->handleFilter("id_st-ASC");
} else {
    $filter = $_GET["filter"];
    $stocks = $stockDataAccess->handleFilter($filter);
    $column = explode("-", $filter)[0];
    $order = explode("-", $filter)[1];
}

switch ($action) {
    case "view":
        include "./views/stock/v_stock.php";
        break;

    case "create":
        include "views/stock/v_createStock.php";
        include "./views/stock/v_stock.php";
        break;

    case "update":
        if (isset($_GET["id"])) {
            $id = htmlspecialchars($_GET["id"]);
            $targetedStock  = $stockDataAccess->getStockByID($id);
            include("views/stock/v_updateStock.php");
            include "./views/stock/v_stock.php";
        } else {
            setcookie("errorMessage", "Aucun stock n'est selectionné", time() + (100000), "/");
            header("location: ./index.php?uc=stock&action=view");
        }
        break;

    case "delete":
        if (isset($_GET["id"])) {
            $id = htmlspecialchars($_GET["id"]);
            include "views/stock/v_deleteStock.php";
            include "./views/stock/v_stock.php";
        } else {
            setcookie("errorMessage", "Aucun stock n'est selectionné", time() + (100000), "/");
            header("location: ./index.php?uc=stock&action=view");
        }
        break;

    case "validForm":
        //for delete a stock 
        if (isset($_POST["delete"]) && isset($_POST["id"])) {
            try {
                $stockDataAccess->deleteStock($_POST["id"]);
                header("location: ./index.php?uc=stock&action=view");
            } catch (Exception $e) {
                setcookie("errorMessage", "Le stock ne peut être supprimé car il est concerné par une commande", time() + (100000), "/");
                header("location: ./index.php?uc=stock&action=view");
            }
        }
        //for update a stock 
        elseif (isset($_POST["id"], $_POST["nom_st"], $_POST["description_st"], $_POST["type_st"])) {
            $id_st = htmlspecialchars($_POST["id"]);
            $nom_st = htmlspecialchars($_POST["nom_st"]);
            $description_st = htmlspecialchars($_POST["description_st"]);
            $type_st = htmlspecialchars($_POST["type_st"]);
            try {
                $stockDataAccess->updateStock($id_st, $nom_st, $description_st, $type_st);
                header("location: ./index.php?uc=stock&action=view");
            } catch (Exception $e) {
                $userDataAccess->writeLog($e, 'unknownErrorLogs.log');
                setcookie("errorMessage", "Une erreur inconnue s'est produite ", time() + (100000), "/");
                header("location: ./index.php?uc=stock&action=view");
            }
        }
        //for create a stock
        elseif (!isset($_POST["id"], $_POST["nom_st"], $_POST["description_st"], $_POST["quantite_st"], $_POST["type_st"])) {
            $nom_st = htmlspecialchars($_POST["nom_st"]);
            $description_st = htmlspecialchars($_POST["description_st"]);
            $quantite_st = htmlspecialchars($_POST["quantite_st"]);
            $type_st = htmlspecialchars($_POST["type_st"]);
            $stockDataAccess->createStock($nom_st, $description_st, $quantite_st, $type_st);
            header("location: ./index.php?uc=stock&action=view");
        }
        break;
}
