<?php
$host = 'localhost'; // Hôte de la base de données
$dbname = 'GStockB'; // Nom de la base de données
$username = 'GStockB'; // Nom d'utilisateur de la base de données
$password = 'Tsqa&r7PT&!pHc'; // Mot de passe de la base de données

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Définir le mode d'erreur de PDO à exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Impossible de se connecter à la base de données : " . $e->getMessage());
}
