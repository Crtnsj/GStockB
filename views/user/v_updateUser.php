<div class="popUpBox--create popUpBox">
    <h2>Modifier un utilisateur</h2>
    <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
    <form action="index.php?uc=user&action=validForm" method="post">
        <input type="hidden" name="id" value="<?php echo $targetedUser->id_u; ?>">
        <div class="signupForm__names">
            <div>
                <p>Nom </p>
                <input type="text" name="nom_u" value="<?php echo $targetedUser->nom_u; ?>">
            </div>
            <div>
                <p>Prenom</p>
                <input type="text" name="prenom_u" value="<?php echo $targetedUser->prenom_u; ?>">
            </div>
        </div>
        <div>
            <p>Role</p>
            <input type=" number" name="id_role" value="<?php echo $targetedUser->id_role; ?>"> <?php //todo : create a comboBox for roles
                                                                                                ?>
        </div>
        <div>
            <p>Email</p>
            <input type="email" name="email_u" value="<?php echo $targetedUser->email_u; ?>">
        </div>
        <input type="submit" value="Valider">
    </form>
    <form action="index.php?uc=user&action=validForm" method="post">
        <input type="hidden" name="id" value="<?php echo $targetedUser->id_u; ?>">
        <h2>Changer le mot de passe</h2>
        <div>
            <p>Ancien mot de passe</p>
            <input type="password" name="ancien_mot_de_passe" />
        </div>
        <div>
            <p>Mot de passe</p>
            <input type="password" name="mot_de_passe" />
        </div>
        <input type="submit" value="Valider">
    </form>

</div>