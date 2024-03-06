<a href="./index.php?uc=order&action=create" class="btnAdd "><i class="ti ti-shopping-cart-plus"></i>Créer une commande</a>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Type</th>
            <th>Utilisateur</th>
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
                <?php echo ($_SESSION['id_role'] == 1) ?
                    "<td><a><i class='ti ti-shopping-cart-x' style='color:#E41B50;'></i></a><a href='./index.php?uc=order&action=validOrder&id_co=$order->id_co'><i class='ti ti-shopping-cart-check' style='color:#50BE0E;'></i></a>
                    <a href='./index.php?uc=order&action=viewDetails&id_co=$order->id_co'>voir les details</a></td>" : "<td><a href='./index.php?uc=order&action=viewDetails&id_co=$order->id_co'>voir les details</a></td>"; ?>
            </tr>
        <?php } ?>
    </tbody>
</table>