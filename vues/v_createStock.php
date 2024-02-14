<?php
include "../controllers/stock.php";

$stockAccess = new Stock();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_st = $_POST["nom_st"];
    $description_st = $_POST["description_st"];
    $quantite_st = $_POST["quantite_st"];
    $type_st = $_POST["type_st"];

    $stockAccess->createStock($nom_st, $description_st, $quantite_st, $type_st);
}

?>

<form action="" method="post">
    <input type="text" name="nom_st" id="">
    <input type="text" name="description_st" id="">
    <input type="number" name="quantite_st" id="">
    <input type="text" name="type_st" id="">
    <input type="submit" value="Valider la création">
</form>