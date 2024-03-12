<?php

function writeLog($message, $filename)
{
    // !! Important, vous devez avoir les droits sur le répertoire cible
    $logMessage = date('[Y-m-d H:i:s]') . ' ' . $message . PHP_EOL;
    $outputFile = __DIR__ . '/../logs/' . $filename;
    echo $outputFile;
    file_put_contents($outputFile, $logMessage, FILE_APPEND);
}

//Ajout de l'entete HTML
require("./views/v_head.php");

//Import du controlleur APP
require("./core/App.php");

//Ajout du pied de page HTML
require("./views/v_foot.php");
