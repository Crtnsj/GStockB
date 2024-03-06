<a href="./index.php?uc=stock&action=create" class="btnAdd"><i class="ti ti-cube-plus"></i>Créer un stock</a>

<table class="table">
    <thead>
        <tr>
            <th><a href="./index.php?uc=stock&action=view&filter=id_st-<?php echo $column === 'id_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>"># <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=stock&action=view&filter=nom_st-<?php echo $column === 'nom_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Nom <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=stock&action=view&filter=description_st-<?php echo $column === 'description_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Description<i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=stock&action=view&filter=quantite_st-<?php echo $column === 'quantite_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Quantité <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=stock&action=view&filter=type_st-<?php echo $column === 'type_st' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Type <i class="ti ti-selector"></i></a></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stocks as $stock) { ?>
            <tr>
                <td>

                    <?php echo $stock->id_st; ?>
                </td>
                <td><?php echo $stock->nom_st; ?></td>
                <td><?php echo $stock->description_st; ?></td>
                <td><?php echo $stock->quantite_st; ?></td>
                <td><?php echo $stock->type_st; ?></td>
                <td>
                    <a href="./index.php?uc=stock&action=update&id_st=<?php echo $stock->id_st; ?>"><i class="ti ti-edit"></i></a>
                    <a href="./index.php?uc=stock&action=delete&id_st=<?php echo $stock->id_st; ?>"><i class="ti ti-trash-x"></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>