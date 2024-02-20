<div>
    <form action="index.php?uc=stock&action=validForm" method="POST">
        <input type="hidden" name="id_st" value="<?php echo htmlspecialchars($_GET["id_st"]); ?>">
        <input type="submit" name="delete" value="Êtes-vous sûr de supprimer ?">
    </form>
</div>