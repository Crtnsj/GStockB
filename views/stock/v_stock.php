<div>
    <table>
        <thead>
            <tr>
                <th><a href="./index.php?uc=stock&action=view&filter=id_st-<?php echo $column === 'id_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">ID</a></th>
                <th><a href="./index.php?uc=stock&action=view&filter=nom_st-<?php echo $column === 'nom_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Nom</a></th>
                <th><a href="./index.php?uc=stock&action=view&filter=description_st-<?php echo $column === 'description_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Description</a></th>
                <th><a href="./index.php?uc=stock&action=view&filter=quantite_st-<?php echo $column === 'quantite_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Quantité</a></th>
                <th><a href="./index.php?uc=stock&action=view&filter=type_st-<?php echo $column === 'type_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Type</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stocks as $stock) { ?>
                <tr>
                    <td>
                        <a href="./index.php?uc=stock&action=update&id_st=<?php echo $stock->id_st; ?>">modifier</a>
                        <a href="./index.php?uc=stock&action=delete&id_st=<?php echo $stock->id_st; ?>">supprimer</a>
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

<a href="./index.php?uc=stock&action=create">Créer un stock</a>
<a href="./index.php?uc=home">Revenir à l'accueil</a>