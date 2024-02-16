<div>
    <form action="index.php?uc=stock&action=validForm" method="POST">
        <input type="hidden" name="id_st" value="<?php echo $id; ?>">
        <input type="text" name="nom_st" id="" value="<?php echo $stock->nom_st ?? ''; ?>">
        <input type="text" name="description_st" id="" value="<?php echo $stock->description_st ?? ''; ?>">
        <input type="number" name="quantite_st" id="" value="<?php echo $stock->quantite_st ?? ''; ?>">
        <select name="type_st" id="">
            <option value="medicament" <?php if ($stock->type_st === 'medicament') echo 'selected'; ?>>medicament</option>
            <option value="outils" <?php if ($stock->type_st === 'materiel') echo 'selected'; ?>>materiel</option>
        </select>
        <input type="submit" value="Valider">
    </form>
</div>