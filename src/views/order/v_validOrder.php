<div class="popUpBox--remove popUpBox">
    <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
    <form action="index.php?uc=order&action=validForm" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]); ?>">
        <input type="submit" name="valid" value="Êtes-vous sûr de valider ?">
    </form>
</div>