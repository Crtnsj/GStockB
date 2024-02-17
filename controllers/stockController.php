<?php
//definition de $action pour connaitre l'action souhaitee
$action = empty($_GET["action"]) ? "view" : $_GET["action"];

//Donne l'acces a la BDD
include("../core/database/pdo.php");
$db = new Database();
//donne l'acces au modele
include("./models/Stock.php");
//creer un instance de classe
$stockAccess = new Stock();
//creer un tableau de valeur avec les stocks
$stocks = $stockAccess->getStocks();

$stock = null;
$id = null;

//redirection vers les vues ou services
switch ($action) {
    case "view":
        include('./vues/v_stock.php');
        break;
    case "update":
        if (isset($_GET["id_st"])) {
            $id = htmlspecialchars($_GET["id_st"]);
            //creer $stockArray qui contient les informations du stock pour preremplir le formulaire
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
        //validation des formulaires de creation/modification
    case "validForm":
        //recuperation des donnees des formulaires
        $id = htmlspecialchars($_POST["id_st"]);
        $nom_st = htmlspecialchars($_POST["nom_st"]);
        $description_st = htmlspecialchars($_POST["description_st"]);
        $quantite_st = htmlspecialchars($_POST["quantite_st"]);
        $type_st = htmlspecialchars($_POST["type_st"]);
        //creer ou modifie un stock
        if (empty($_POST["id_st"])) {
            $stockAccess->createStock($nom_st, $description_st, $quantite_st, $type_st);
        } else {
            $stockAccess->updateStock($id, $nom_st, $description_st, $quantite_st, $type_st);
        }
        //renvoie vers la page de visualisation des stocks
        header("location: index.php?uc=stock&action=view");
        break;
}
