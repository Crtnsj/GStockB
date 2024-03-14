<div class="popUpBox--remove popUpBox">
    <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
    <table class="table">
        <thead>
            <tr>
                <th>Stock</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails as $orderDetail) { ?>
                <tr>
                    <td><?php echo $orderDetail->nom_st; ?></td>
                    <td><?php echo $orderDetail->quantite_details; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>