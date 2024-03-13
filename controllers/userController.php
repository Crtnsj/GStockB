<?php

if (empty($_GET["filter"])) {
    $users = $userDataAccess->handleFilter("id_u-ASC");
} else {
    $filter = $_GET["filter"];
    $users = $userDataAccess->handleFilter($filter);
    $column = explode("-", $filter)[0];
    $order = explode("-", $filter)[1];
}

$action = $_GET["action"];

switch ($action) {
    case "view":
        include "./views/user/v_user.php";
        break;
    case "create":
        include "./views/user/v_createUser.php";
        include "./views/user/v_user.php";
        break;
    case "validForm":
        //for create account
        if (isset($_POST["nom_u"]) && isset($_POST["prenom_u"])) {
            $nom_u = htmlspecialchars($_POST["nom_u"]);
            $prenom_u = htmlspecialchars($_POST["prenom_u"]);
            $id_role = htmlspecialchars($_POST["id_role"]);
            $email_u = htmlspecialchars($_POST["email_u"]);
            $mot_de_passe = htmlspecialchars($_POST["mot_de_passe"]);
            try {
                $userDataAccess->createUser($nom_u, $prenom_u, $email_u, $mot_de_passe, $id_role);
            } catch (Exception $e) {
                $userDataAccess->writeLog($e, 'userErrorLogs.log');
            }
        }
        //for disable account
        if (isset($_POST["disable"]) && isset($_POST["id"])) {

            try {
                $userDataAccess->disableUser($_POST["id"]);
                header("location: ./index.php?uc=user&action=view");
            } catch (Exception $e) {
                $userDataAccess->writeLog($e, 'userErrorLogs.log');
                setcookie("errorMessage", "Une erreur inconnue s'est produite", time() + (100000), "/");
                header("location: ./index.php?uc=stock&action=view");
            }
        }
        break;


    case "disable":
        if ($_GET["id"] != 2) {
            $users = $userDataAccess->handleFilter("id_u-ASC");
            include "./views/user/v_disableUser.php";
            include "./views/user/v_user.php";
        } else {
            setcookie("errorMessage", "L'administrateur ne peut être desactivé", time() + (100000), "/");
            header("Location: index.php?uc=user&action=view");
        }
        break;
}
