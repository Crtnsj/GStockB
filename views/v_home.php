<div class="dashboard">
    <div>Liste des stocks les plus faibles
        <table>
            <thead class="table">
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
    <div>Dernieres commandes</div>
    <div>Nombre de commandes en attentes de validations
        <?php echo $numberOfOrderInValidation ?>
    </div>
    <div>Nombres de commandes réalisés
        <?php echo $numberOfOrder ?>
    </div>
    <div>Stocks les plus populaires
        <table>
            <thead class="table">
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
        <?php echo $numberOfStock ?>
    </div>
    <div>Nombre d'utilisateurs
        <?php echo $numberOfUser ?>
    </div>
    <div>Liste des commandes</div>
</div>