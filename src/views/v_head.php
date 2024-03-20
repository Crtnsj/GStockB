<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GStockB</title>
    <link rel="icon" href="./pics/favicon.ico" />
    <link href="./styles/css-compiled.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>

    <?php if (isset($_GET["uc"]) && isset($_SESSION["id_u"])) : ?>
        <div class="navBar">
            <nav>
                <ul>
                    <a href="./index.php?uc=home" class="nav__logo"><img src="./pics/Logo_GStockB.png" alt=""></img></a>
                    <li><a href="./index.php?uc=stock&action=view"><i class="ti ti-package"></i>Voir les stocks</a></li>
                    <li><a href="./index.php?uc=order&action=view"><i class="ti ti-shopping-cart"></i>Voir les commandes</a></li>
                    <?php if ($_SESSION["id_role"] == 1) : ?>
                        <li><a href='./index.php?uc=user&action=view'><i class='ti ti-user-cog'></i>Gérer les utilisateurs</a></li>
                    <?php endif; ?>
                    <li><a href="./index.php?uc=disconnect"><i class="ti ti-logout"></i>Se déconnecter</a></li>
                </ul>
            </nav>
        </div>
        <div class="content">
        <?php endif; ?>
        <?php if (isset($_COOKIE["errorMessage"])) : ?>
            <div class="popUpBox--error popUpBox">
                <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
                <span><?php echo $_COOKIE["errorMessage"]; ?></span>
            </div>

        <?php elseif (isset($_COOKIE["successMessage"])) : ?>
            <div class="popUpBox--success popUpBox">
                <button onclick="closePopUp()"><i class="ti ti-square-x"></i></button>
                <span><?php echo $_COOKIE["successMessage"]; ?></span>
            </div>
        <?php endif; ?>