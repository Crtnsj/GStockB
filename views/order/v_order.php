<a href="./index.php?uc=order&action=create" class="btnAdd "><i class="ti ti-shopping-cart-plus"></i>Créer une commande</a>
<table class="table">
    <thead>
        <tr>
            <th><a href="./index.php?uc=order&action=view&filter=id_co-<?php echo $column === 'id_co' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>"># <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=order&action=view&filter=date_co-<?php echo $column === 'date_co' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Date <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=order&action=view&filter=statut_co-<?php echo $column === 'statut_co' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Statut<i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=order&action=view&filter=type_co-<?php echo $column === 'type_co' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Type <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=order&action=view&filter=id_u-<?php echo $column === 'id_u' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Utilisateur <i class="ti ti-selector"></i></a></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order) { ?>
            <tr>
                <td><?php echo $order->id_co; ?></td>
                <td><?php echo $order->date_co; ?></td>
                <td><?php echo $order->statut_co; ?></td>
                <td><?php echo $order->type_co; ?></td>
                <td><?php echo $order->id_u; ?></td>
                <?php echo ($_SESSION['id_role'] < 3 && $order->statut_co != "validee" && $order->statut_co != "invalidée") ?
                    "<td>
                    <a href='./index.php?uc=order&action=rejectOrder&id=$order->id_co'><i class='ti ti-shopping-cart-x'></i></a>
                    <a href='./index.php?uc=order&action=validOrder&id=$order->id_co'><i class='ti ti-shopping-cart-check'></i></a>
                    <a href='./index.php?uc=order&action=viewDetails&id_co=$order->id_co'>voir les details</a>
                    </td>"
                    :
                    "<td><a href='./index.php?uc=order&action=viewDetails&id_co=$order->id_co'>voir les details</a></td>"; ?>
            </tr>
        <?php } ?>
    </tbody>
</table>