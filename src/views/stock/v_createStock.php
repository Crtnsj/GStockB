<div class="popUpBox popUpBox--create">
    <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
    <form action="index.php?uc=stock&action=validForm" method="post">
        <p>Nom du stock</p>
        <input type="text" name="nom_st">
        <p>Description</p>
        <textarea type="text" name="description_st"></textarea>
        <p>Quantité</p>
        <input type="number" name="quantite_st">
        <p>Email</p>
        <select name="type_st">
            <option value="medicament">Médicament</option>
            <option value="materiel">Matériel</option>
            <option value="materiel">Autre</option>
        </select>
        <input type="submit" value="Valider la création">
    </form>
</div>