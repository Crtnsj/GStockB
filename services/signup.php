<?php

include "../models/User.php";
$userAccess = new User();

try {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $hash = password_hash($password, PASSWORD_DEFAULT);


        $userAccess->createUser($fname, $lname, $email, $hash);

        header("location: ../index.php?uc=home");
    } else {
        echo "tous les champs ne sont pas remplit";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
