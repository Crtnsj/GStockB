<div class="removeBox">
    <form action="index.php?uc=user&action=validForm" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]); ?>">
        <input type="submit" name="disable" value="Êtes-vous sûr de desactiver ?">
    </form>
    <a href="./index.php?uc=user&action=view">Revenir en arriere</a>
</div>