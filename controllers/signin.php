<?php

include '../API/pdo.php';
global $db;
session_start();
try {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM utilisateurs WHERE email_u = :email AND mot_de_passe = :password";
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $email, 'password' => $password]);
        $result = $stmt->fetch();

        if ($result) {
            if ($password == $result['mot_de_passe']) {
                $_SESSION['id_u'] = $result["id_u"];
                $_SESSION['email_u'] = $result['email_u'];
                $_SESSION['lname'] = $result['nom_u'];
                $_SESSION['fname'] = $result['prenom_u'];
                header("location: ../vues/v_home.php");
                exit();
            } else {
                echo "Votre mot de passe est incorrect";
            }
        } else {
            echo "Votre email est incorrect";
        }
    } else {
        echo "Tous les champs ne sont pas remplis";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
