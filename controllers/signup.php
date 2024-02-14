<?php

include "../api/pdo.php";
$db = new Database();

try {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `utilisateurs` (`id_u`, `nom_u`, `prenom_u`, `email_u`, `mot_de_passe`, `id_role`) VALUES (NULL, :lname , :fname, :email, :hash, '2');";
        $db->query($sql);
        $db->bind(':lname', $lname);
        $db->bind(':fname', $fname);
        $db->bind(':email', $email);
        $db->bind(':hash', $hash);
        $db->execute();
    } else {
        echo "tous les champs ne sont pas remplit";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
