<?php
$action = empty($_GET["action"]) ? "view" : $_GET["action"];

include("./models/Order.php");
$orderAccess = new Order();
$orders = $orderAccess->getOrders();

switch ($action) {
    case "view":
        include('./vues/v_order.php');
        break;
    case "create":
        include("./vues/v_createOrder.php");
        break;
    case "validForm":
        $id = htmlspecialchars($_POST["id_co"]);
        $type_co = htmlspecialchars($_POST["type_co"]);
        if (empty($_POST["id_co"])) {
            $orderAccess->createOrder($type_co);
        }
        header("location: index.php?uc=order&action=view");
        break;
}
