<?php
$_SESSION = array();

// Destruction de la session
session_destroy();

// Redirection vers la page de connexion
header("Location: index.php");
exit;
