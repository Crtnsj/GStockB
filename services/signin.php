<?php
include "../models/User.php";
$userAccess = new User();


try {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $result = $userAccess->getUserbyEmail($email);

        if ($result) {
            $user = $result[0];
            if (password_verify($password, $user->mot_de_passe)) {
                $_SESSION['id_u'] = $user->id_u;
                header("location: ../index.php?uc=home");
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
