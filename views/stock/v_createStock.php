<div class="removeBox pop-up-box">
    <form action="index.php?uc=stock&action=validForm" method="post">
        <input type="text" name="nom_st" id="">
        <input type="text" name="description_st" id="">
        <input type="number" name="quantite_st" id="">
        <select name="type_st" id="">
            <option value="medicament">Médicament</option>
            <option value="materiel">Matériel</option>
            <option value="materiel">Autre</option>
        </select>
        <input type="submit" value="Valider la création">
    </form>
</div>