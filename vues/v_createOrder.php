<div>
    <form action="index.php?uc=order&action=validForm" method="post">
        <select name="type_co" id="">
            <option value="entrée" <?php if ($order->type_co === 'entrée') echo 'selected'; ?>>Entrée</option>
            <option value="sortie" <?php if ($order->type_co === 'sortie') echo 'selected'; ?>>Sortie</option>
        </select>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Type</th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="test" id=""></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="Valider la creation">
    </form>
</div>