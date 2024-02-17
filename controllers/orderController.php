<?php

//Donne l'acces a la BDD
include("../core/database/pdo.php");
$db = new Database();
//definition de $action pour connaitre l'action souhaitee
$action = empty($_GET["action"]) ? "view" : $_GET["action"];
//donne l'acces aux modeles
include("./models/Order.php");
include("./models/Stock.php");
//creer des instances des classes
$stockAccess = new Stock();
$orderAccess = new Order();
//creer un tableau de valeur avec les commandes
$orders = $orderAccess->getOrders();
//stock la date et l'heure actuelle
$actualDate = date('Y-m-d H:i:s');

//redirection vers les vues ou services
switch ($action) {
    case "view":
        include('./vues/v_order.php');
        break;
    case "create":
        //import des noms de stocks disponibles pour la liste deroulante
        $stocks = $stockAccess->getStocksNames();
        include("./vues/v_createOrder.php");
        break;

        //validation des formulaires de creation/modification
    case "validForm":
        //utile pour savoir quelle commande modifier
        $id_co = htmlspecialchars($_POST["id_co"]);
        //recuperation des valeur du formulaire
        $type_co = htmlspecialchars($_POST["type_co"]);
        $numberOfStocks = htmlspecialchars($_POST["numberOfStocks"]);
        // Initialisation du tableau $stock
        $stock = array();
        //trie entre formulaire de modification et de creation
        if (empty($_POST["id_co"])) {
            $date_co = $actualDate;
            //creer la commande
            $orderAccess->createOrder($type_co, $date_co);
            //definit l'id de la commande qui vient d'etre cree
            $id = $orderAccess->getOrderByDate($date_co);

            //pour chaque stock -> creer un details de la commande
            for ($i = 1; $i <= $numberOfStocks; $i++) {
                //recupere le nom du stock
                $stock[$i] = htmlspecialchars($_POST["stock" . $i]);
                //traduit le nom du stock par son id
                $translateID_st = $stockAccess->translateNameToID($stock[$i]);
                //recupere la quantite
                $qte[$i] = htmlspecialchars($_POST["qte" . $i]);
                //creer un details de la commande
                $orderAccess->createOrderDetails($id[0]->id_co, $translateID_st[0]->id_st, $qte[$i]);
            }
            //renvoie la page de visualisation des commandes
            header("location: index.php?uc=order&action=view");
        }

        break;
    case "delete":
        if (isset($_GET["id_co"])) {
            $id = htmlspecialchars($_GET["id_co"]);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $orderAccess->deleteOrder($id);
            header("location: index.php?uc=order&action=view");
        }
        include("vues/v_deleteOrder.php");
        break;
    case "viewDetails":
        $id_co = htmlspecialchars($_GET["id_co"]);
        $orderDetails = $orderAccess->getDetails($id_co);
        include("vues/v_viewDetails.php");
        break;
}
