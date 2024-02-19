<?php

$stockDataAccess = new stock();

$action = $_GET["action"];

switch ($action) {
    case "view":
        $stocks = $stockDataAccess->getStocks();
        include "./views/stock/v_stock.php";
        break;
}
