<?php
// Démarrez la session
session_start();

// Vérifiez si les informations de l'utilisateur sont présentes dans les variables de session
echo $_SESSION["fname"];
echo $_SESSION["lname"];
echo $_SESSION["email_u"];
echo $_SESSION["id_u"];
