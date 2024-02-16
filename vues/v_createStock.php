<form action="index.php?uc=stock&action=validForm" method="post">
    <input type="text" name="nom_st" id="">
    <input type="text" name="description_st" id="">
    <input type="number" name="quantite_st" id="">
    <select name="type_st" id="">
        <option value="medicament" <?php if ($stock->type_st === 'medicament') echo 'selected'; ?>>medicament</option>
        <option value="outils" <?php if ($stock->type_st === 'materiel') echo 'selected'; ?>>materiel</option>
    </select>
    <input type="submit" value="Valider la création">
</form>