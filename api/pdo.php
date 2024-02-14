<?php
//connexion a la base de donnée
define('HOST', 'localhost');
define('DB_NAME', 'GStockB');
define('USER', 'root');
define('PASS', '');

try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS); //variable  qui accede a la base de donnée
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connect > ok "; // si il arrive a se connecté il dirat ok
} catch (PDOException $e) { //sinon il affichera cette erreur
    echo $e;
}
