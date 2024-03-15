<div class="popUpBox popUpBox--remove">
    <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
    <form action="index.php?uc=stock&action=validForm" method="post">
        <input type="text" name="nom_st">
        <input type="text" name="description_st">
        <input type="number" name="quantite_st">
        <select name="type_st">
            <option value="medicament">Médicament</option>
            <option value="materiel">Matériel</option>
            <option value="materiel">Autre</option>
        </select>
        <input type="submit" value="Valider la création">
    </form>
</div>