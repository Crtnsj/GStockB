<?php
$action = empty($_GET["action"]) ? "view" : $_GET["action"];

include("./models/Order.php");
$orderAccess = new Order();
$orders = $orderAccess->getOrders();
$id = null;

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
        echo (htmlspecialchars($_POST["test"]));
        // if (empty($_POST["id_co"])) {
        //     $orderAccess->createOrder($type_co);
        // }
        // header("location: index.php?uc=order&action=view");
        break;
    case "delete":
        echo "hello";
        if (isset($_GET["id_co"])) {
            $id = htmlspecialchars($_GET["id_co"]);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $orderAccess->deleteOrder($id);
            header("location: index.php?uc=order&action=view");
        }
        include("vues/v_deleteOrder.php");
        break;
}
