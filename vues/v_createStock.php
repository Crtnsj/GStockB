<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_st = htmlspecialchars($_POST["nom_st"]);
    $description_st = htmlspecialchars($_POST["description_st"]);
    $quantite_st = htmlspecialchars($_POST["quantite_st"]);
    $type_st = htmlspecialchars($_POST["type_st"]);

    $stockAccess->createStock($nom_st, $description_st, $quantite_st, $type_st);
    header("location: index.php?uc=stock&action=view");
}

?>

<form action="" method="post">
    <input type="text" name="nom_st" id="">
    <input type="text" name="description_st" id="">
    <input type="number" name="quantite_st" id="">
    <select name="type_st" id="">
        <option value="medicament" <?php if ($stock->type_st === 'medicament') echo 'selected'; ?>>medicament</option>
        <option value="outils" <?php if ($stock->type_st === 'materiel') echo 'selected'; ?>>materiel</option>
    </select>
    <input type="submit" value="Valider la création">
</form>