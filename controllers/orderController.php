<?php

$orderDataAccess = new Order();

$action = $_GET["action"];

switch ($action) {
    case "view":
        $orders = $orderDataAccess->getOrders();
        //var_dump($orders);
        include "./views/order/v_order.php";
        break;
}
