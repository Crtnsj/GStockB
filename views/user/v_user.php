<a href="./index.php?uc=order&action=create" class="btnAdd "><i class="ti ti-user-plus"></i>Créer un utilisateur</a>
<table class="table">
    <thead>
        <tr>
            <th><a href="./index.php?uc=user&action=view&filter=id_u-<?php echo $column === 'id_u' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>"># <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=user&action=view&filter=nom_u-<?php echo $column === 'nom_u' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Nom <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=user&action=view&filter=prenom_u-<?php echo $column === 'prenom_u' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Prénom<i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=user&action=view&filter=email_u-<?php echo $column === 'email_u' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Email <i class="ti ti-selector"></i></a></th>
            <th><a href="./index.php?uc=user&action=view&filter=id_role-<?php echo $column === 'id_role' && $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Rôle <i class="ti ti-selector"></i></a></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user->id_u; ?></td>
                <td><?php echo $user->nom_u; ?></td>
                <td><?php echo $user->prenom_u; ?></td>
                <td><?php echo $user->email_u; ?></td>
                <td><?php echo $user->id_role; ?></td>
                <td>
                    <a><i class='ti ti-user-edit'></i></a>
                    <a><i class='ti ti-user-off'></i></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>