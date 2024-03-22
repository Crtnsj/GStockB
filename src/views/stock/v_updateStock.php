<div class="popUpBox--create popUpBox">
    <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
    <form action="index.php?uc=stock&action=validForm" method="POST">
        <input type="hidden" name="id" value="<?php echo $targetedStock->id_st; ?>">
        <p>Nom du stock</p>
        <input type="text" name="nom_st" value="<?php echo $targetedStock->nom_st; ?>">
        <p>Description</p>
        <textarea type="text" name="description_st"><?php echo $targetedStock->description_st; ?></textarea>
        <p>Quantite : <?php echo $targetedStock->quantite_st; ?></p>
        <p>Type</p>
        <select name="type_st">
            <option value="medicament" <?php if ($targetedStock->type_st === 'medicament') echo 'selected'; ?>>Médicament</option>
            <option value="materiel" <?php if ($targetedStock->type_st === 'materiel') echo 'selected'; ?>>Matériel</option>
            <option value="autre" <?php if ($targetedStock->type_st === 'autre') echo 'selected'; ?>>Autre</option>
        </select>
        <input type="submit" value="Valider">
    </form>
</div>