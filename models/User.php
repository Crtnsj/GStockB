<?php
include("../core/database/pdo.php");
$db = new Database();
class User
{
    function getUserbyEmail($email)
    {
        global $db;
        $sql = "SELECT `id_u`,`mot_de_passe` FROM utilisateurs WHERE email_u = :email";
        $db->query($sql);
        $db->bind(':email', $email);
        $result = $db->resultSet();
        return $result;
    }
    function createUser($lname, $fname, $email, $hash)
    {
        global $db;
        $sql = "INSERT INTO `utilisateurs` (`id_u`, `nom_u`, `prenom_u`, `email_u`, `mot_de_passe`, `id_role`) VALUES (NULL, :lname , :fname, :email, :hash, '2');";
        $db->query($sql);
        $db->bind(':lname', $lname);
        $db->bind(':fname', $fname);
        $db->bind(':email', $email);
        $db->bind(':hash', $hash);
        $db->execute();
    }
}
