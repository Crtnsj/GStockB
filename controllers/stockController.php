<?php
$action = empty($_GET["action"]) ? "view" : $_GET["action"];

include("./models/stock.php");
$stockAccess = new Stock();
$stocks = $stockAccess->getStocks();
$stock = null;
$id = null;


switch ($action) {
    case "view":
        include('./vues/v_stock.php');
        break;
    case "update":
        include("vues/v_updateStock.php");
        break;
    case "create":
        include("vues/v_createStock.php");
        break;
    case "delete":
        include("vues/v_deleteStock.php");
        break;
}
