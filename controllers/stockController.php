<?php
$action = empty($_GET["action"]) ? "view" : $_GET["action"];
include("../core/database/pdo.php");
$db = new Database();
include("./models/Stock.php");
$stockAccess = new Stock();
$stocks = $stockAccess->getStocks();
$stock = null;
$id = null;


switch ($action) {
    case "view":
        include('./vues/v_stock.php');
        break;
    case "update":
        if (isset($_GET["id_st"])) {
            $id = htmlspecialchars($_GET["id_st"]);
            $stockArray = $stockAccess->getStockByID($id);
            if (!empty($stockArray) && isset($stockArray[0])) {
                $stock = $stockArray[0];
            }
        }
        include("vues/v_updateStock.php");
        break;
    case "create":
        include("vues/v_createStock.php");
        break;
    case "delete":
        if (isset($_GET["id_st"])) {
            $id = htmlspecialchars($_GET["id_st"]);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stockAccess->deleteStock($id);
            header("location: index.php?uc=stock&action=view");
        }
        include("vues/v_deleteStock.php");
        break;
    case "validForm":
        $id = htmlspecialchars($_POST["id_st"]);
        $nom_st = htmlspecialchars($_POST["nom_st"]);
        $description_st = htmlspecialchars($_POST["description_st"]);
        $quantite_st = htmlspecialchars($_POST["quantite_st"]);
        $type_st = htmlspecialchars($_POST["type_st"]);
        if (empty($_POST["id_st"])) {
            $stockAccess->createStock($nom_st, $description_st, $quantite_st, $type_st);
        } else {
            $stockAccess->updateStock($id, $nom_st, $description_st, $quantite_st, $type_st);
        }
        header("location: index.php?uc=stock&action=view");
        break;
}
