<?php
include "../controllers/stock.php";
$stockAccess = new Stock();

$stocks = $stockAccess->getStocks();

foreach ($stocks as $stock) {
    echo $stock->nom_st;
}
echo '<a href="./v_createStock.php">créer un stock</a>';
