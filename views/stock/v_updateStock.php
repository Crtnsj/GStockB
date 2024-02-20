<div>
    <form action="index.php?uc=stock&action=validForm" method="POST">
        <input type="hidden" name="id_st" value="<?php echo $targetedStock[0]->id_st; ?>">
        <input type="text" name="nom_st" id="" value="<?php echo $targetedStock[0]->nom_st ?? ''; ?>">
        <input type="text" name="description_st" id="" value="<?php echo $targetedStock[0]->description_st ?? ''; ?>">
        <input type="number" name="quantite_st" id="" value="<?php echo $targetedStock[0]->quantite_st ?? ''; ?>">
        <select name="type_st" id="">
            <option value="medicament" <?php if ($targetedStock[0]->type_st === 'medicament') echo 'selected'; ?>>Médicament</option>
            <option value="outils" <?php if ($targetedStock[0]->type_st === 'materiel') echo 'selected'; ?>>Matériel</option>
            <option value="autre" <?php if ($targetedStock[0]->type_st === 'autre') echo 'selected'; ?>>Autre</option>
        </select>
        <input type="submit" value="Valider">
    </form>
</div>