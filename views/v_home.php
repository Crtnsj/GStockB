<div class="dashboard">
    <div>Liste des stocks les plus faibles
        <table>
            <thead>
                <tr>
                    <th>Stock</th>
                    <th>quantite</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lowStocks as $stock) { ?>
                    <tr>
                        <td><?php echo $stock->id_st ?></td>
                        <td><?php echo $stock->quantite_st ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div>Dernieres commandes
        <table>
            <thead>
                <tr>
                    <th>Commande</th>
                    <th>Date de commande</th>
                    <th>Commande</th>
                    <th>Date de commande</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($lastOrders); $i++) {
                    if ($i < 5) { ?>
                        <tr>

                            <td><?php echo $lastOrders[$i]->id_co ?></td>
                            <td><?php echo $lastOrders[$i]->date_co ?></td>
                            <td><?php echo $lastOrders[$i + 5]->id_co ?></td>
                            <td><?php echo $lastOrders[$i + 5]->date_co ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
    <div>Nombre de commandes en attentes de validations
        <p><?php echo $numberOfOrderInValidation ?></p>
    </div>
    <div>Nombres de commandes réalisés
        <p><?php echo $numberOfOrder ?></p>
    </div>
    <div>Stocks les plus populaires
        <table>
            <thead>
                <tr>
                    <th>Stock</th>
                    <th>Nombre de commandes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($popularStocks as $stock) { ?>
                    <tr>
                        <td><?php echo $stock->id_st ?></td>
                        <td><?php echo $stock->count ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div>Nombre total de stocks
        <p><?php echo $numberOfStock ?></p>
    </div>
    <div>Nombre d'utilisateurs
        <p><?php echo $numberOfUser ?></p>
    </div>
    <div>Liste des commandes
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date </th>
                    <th>Statut</th>
                    <th>Type </th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderList as $order) { ?>
                    <tr>
                        <td><?php echo $order->id_co; ?></td>
                        <td><?php echo $order->date_co; ?></td>
                        <td><?php echo $order->statut_co; ?></td>
                        <td><?php echo $order->type_co; ?></td>
                        <td><?php echo $order->id_u; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>