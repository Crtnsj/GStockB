<div class="dashboard">
    <a href="./index.php?uc=stock&action=view" class="dashboard--element">
        <div><i class="ti ti-math-lower"></i>
            <p>Liste des stocks les plus faibles</p>
        </div>
        <table class="table table--dashboard">
            <a href="./index.php?uc=order&action=create" class="btnAdd">Créer une commande</a>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>quantite</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lowStocks as $stock) { ?>
                    <tr>
                        <td><?php echo $stock->id_st ?></td>
                        <td><?php echo $stockDataAccess->translateIDToName($stock->id_st) ?></td>
                        <td><?php echo $stock->quantite_st ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </a>
    <a href="./index.php?uc=order&action=view&filter=date_co-DESC" class="dashboard--element">
        <div><i class="ti ti-arrow-bar-to-right"></i>
            <p>Liste des dernieres commandes</p>
        </div>
        <table class="table table--dashboard">
            <thead>
                <tr>
                    <th>Commande</th>
                    <th>Date</th>
                    <th>Commande</th>
                    <th>Date</th>
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
    </a>
    <a href=" index.php?uc=order&action=view&filter=statut_co-ASC" class="dashboard--element">
        <p class="dashboard__number"><?php echo $numberOfOrderInValidation ?></p>
        <div> <i class="ti ti-checkup-list"></i>
            <p>Commandes en attente de validation</p>
        </div>

    </a>
    <a href="index.php?uc=order&action=view&filter=id_co-ASC" class="dashboard--element">
        <p class=" dashboard__number"><?php echo $numberOfOrder ?></p>
        <div> <i class="ti ti-number"></i>
            <p>Nombres de commandes réalisés</p>
        </div>
    </a>
    <a class="dashboard--element">
        <div><i class="ti ti-trending-up"></i>
            <p>Stocks les plus populaires</p>
        </div>
        <table class="table table--dashboard">
            <thead>
                <tr>
                    <th>Stock</th>
                    <th>Nombre de commandes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($popularStocks as $stock) { ?>
                    <tr>
                        <td><?php echo $stockDataAccess->translateIDToName($stock->id_st); ?></td>
                        <td><?php echo $stock->count ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </a>
    <a href="index.php?uc=stock&action=view&filter=id_st-ASC" class="dashboard--element">
        <p class="dashboard__number"><?php echo $numberOfStock ?></p>
        <div> <i class="ti ti-number"></i>
            <p>Nombre total de stocks</p>
        </div>
    </a>
    <a <?php echo $_SESSION["id_role"] == 1 ? "href='./index.php?uc=user&action=view'" : ""; ?> class="dashboard--element">
        <p class="dashboard__number"><?php echo $numberOfUser ?></p>
        <div> <i class="ti ti-users-group"></i>
            <p>Nombre d'utilisateurs actifs</p>
        </div>
    </a>
    <a href="./index.php?uc=order&action=view" class="dashboard--element">
        <div><i class="ti ti-truck-delivery"></i>
            <p>Liste des commandes</p>
        </div>
        <table class="table table--dashboard">
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
                <?php $count = 0;
                foreach ($orderList as $order) {
                    if ($count < 15) { ?>
                        <tr>
                            <td><?php echo $order->id_co; ?></td>
                            <td><?php echo $order->date_co; ?></td>
                            <td><?php echo $order->statut_co; ?></td>
                            <td><?php echo $order->type_co; ?></td>
                            <td><?php echo $order->id_u; ?></td>
                        </tr>
                <?php $count++;
                    } else {
                        break;
                    }
                } ?>
            </tbody>
        </table>
    </a>
</div>