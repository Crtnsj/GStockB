<?php

include "../controllers/stock.php";
$stockAccess = new Stock();
$stock = null;
$id = null;

if (isset($_GET["id_st"])) {
    $id = htmlspecialchars($_GET["id_st"]);
    $stockArray = $stockAccess->getStockByID($id);
    if (!empty($stockArray) && isset($stockArray[0])) {
        $stock = $stockArray[0];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nom_st"]) && isset($_POST["description_st"]) && isset($_POST["quantite_st"]) && isset($_POST["type_st"])) {
        $nom_st = htmlspecialchars($_POST["nom_st"]);
        $description_st = htmlspecialchars($_POST["description_st"]);
        $quantite_st = htmlspecialchars($_POST["quantite_st"]);
        $type_st = htmlspecialchars($_POST["type_st"]);

        $stockAccess->updateStock($id, $nom_st, $description_st, $quantite_st, $type_st);
    }
}
?>

<div>
    <form action="" method="POST">
        <input type="text" name="nom_st" id="" value="<?php echo $stock->nom_st ?? ''; ?>">
        <input type="text" name="description_st" id="" value="<?php echo $stock->description_st ?? ''; ?>">
        <input type="number" name="quantite_st" id="" value="<?php echo $stock->quantite_st ?? ''; ?>">
        <input type="text" name="type_st" id="" value="<?php echo $stock->type_st ?? ''; ?>">
        <input type="submit" value="Valider">
    </form>
</div>