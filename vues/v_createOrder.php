<div>
    <form action="index.php?uc=order&action=validForm" method="post">
        <select name="type_co" id="">
            <option value="entrée" <?php if ($order->type_co === 'entrée') echo 'selected'; ?>>Entrée</option>
            <option value="sortie" <?php if ($order->type_co === 'sortie') echo 'selected'; ?>>Sortie</option>
        </select>
        <input type="submit" value="Valider la creation">
    </form>
</div>