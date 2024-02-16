<div>
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
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td>
                        <a href="./index.php?uc=stock&action=update&id_co=<?php echo $order->id_co; ?>">modifier</a>
                        <a href="./index.php?uc=stock&action=delete&id_co=<?php echo $order->id_co; ?>">supprimer</a>
                        <?php echo $order->id_co; ?>
                    </td>
                    <td><?php echo $order->date_co; ?></td>
                    <td><?php echo $order->statut_co; ?></td>
                    <td><?php echo $order->type_co; ?></td>
                    <td><?php echo $order->id_u; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<a href="./index.php?uc=order&action=create">Créer une commande</a>
<a href="./index.php?uc=home">Revenir à l'accueil</a>