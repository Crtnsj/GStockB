<?php
include "../controllers/stock.php";
$stockAccess = new Stock();

$stocks = $stockAccess->getStocks();

?>
<div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Quantité</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stocks as $stock) { ?>
                <tr>
                    <td>
                        <a href="./v_updateStock.php?id_st=<?php echo $stock->id_st; ?>">modifier</a>
                        <a href="./v_deleteStock.php?id_st=<?php echo $stock->id_st; ?>">supprimer</a>
                        <?php echo $stock->id_st; ?>
                    </td>
                    <td><?php echo $stock->nom_st; ?></td>
                    <td><?php echo $stock->description_st; ?></td>
                    <td><?php echo $stock->quantite_st; ?></td>
                    <td><?php echo $stock->type_st; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<a href="./v_createStock.php">Créer un stock</a>