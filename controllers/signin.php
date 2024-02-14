<?php
session_start();
include "../api/pdo.php";
$db = new Database();

try {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM utilisateurs WHERE email_u = :email";
        $db->query($sql);
        $db->bind(':email', $email);
        $result = $db->resultSet();

        if ($result) {
            $user = $result[0];
            if (password_verify($password, $user->mot_de_passe)) {
                $_SESSION['id_u'] = $user->id_u;
                $_SESSION['email_u'] = $user->email_u;
                $_SESSION['lname'] = $user->nom_u;
                $_SESSION['fname'] = $user->prenom_u;
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
