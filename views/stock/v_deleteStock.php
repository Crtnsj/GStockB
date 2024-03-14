<div class="popUpBox--remove popUpBox">
    <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
    <form action="index.php?uc=stock&action=validForm" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]); ?>">
        <input type="submit" name="delete" value="Êtes-vous sûr de supprimer ?">
    </form>
</div>