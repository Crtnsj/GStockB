<?php

if (isset($_GET["id_st"])) {
    $id = htmlspecialchars($_GET["id_st"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stockAccess->deleteStock($id);
    header("location: index.php?uc=stock&action=view");
}
?>
<div>
    <form action="" method="POST">
        <input type="hidden" name="id_st" value="<?php echo $id; ?>">
        <input type="submit" value="Êtes-vous sûr de supprimer ?">
    </form>
</div>