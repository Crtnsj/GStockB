<?php


echo $_SESSION["fname"];
echo $_SESSION["lname"];
echo $_SESSION["email_u"];
echo $_SESSION["id_u"];
?>
<div>
    <nav>
        <ul>
            <li>
                <a href="index.php?uc=stock&action=view">Voir les stocks</a>
                <a href="index.php?uc=login&action=disconnect">se deconnecter</a>
            </li>
        </ul>
    </nav>
</div>