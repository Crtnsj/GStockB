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
    case "update":
        $targetedUser = $userDataAccess->getUserById($_GET["id"]);
        include "./views/user/v_updateUser.php";
        include "./views/user/v_user.php";
        break;
    case "validForm":
        //for create account
        if (isset($_POST["nom_u"]) && isset($_POST["prenom_u"]) && isset($_POST["id_role"]) && isset($_POST["email_u"]) && isset($_POST["mot_de_passe"])) {
            $nom_u = htmlspecialchars($_POST["nom_u"]);
            $prenom_u = htmlspecialchars($_POST["prenom_u"]);
            $id_role = htmlspecialchars($_POST["id_role"]);
            $email_u = htmlspecialchars($_POST["email_u"]);
            $mot_de_passe = htmlspecialchars($_POST["mot_de_passe"]);
            try {
                $userCreation = $userDataAccess->createUser($nom_u, $prenom_u, $email_u, $mot_de_passe, $id_role);
                if ($userCreation) {
                    setcookie("successMessage", "L'utilisateur a été créer avec succès", time() + (100000), "/");
                } else {
                    setcookie("errorMessage", "L'email est déja existant en base", time() + (100000), "/");
                }
                header("location: ./index.php?uc=user&action=view");
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
        //for enable account
        if (isset($_POST["enable"]) && isset($_POST["id"])) {

            try {
                $userDataAccess->enableUser($_POST["id"]);
                header("location: ./index.php?uc=user&action=view");
            } catch (Exception $e) {
                $userDataAccess->writeLog($e, 'userErrorLogs.log');
                setcookie("errorMessage", "Une erreur inconnue s'est produite", time() + (100000), "/");
                header("location: ./index.php?uc=stock&action=view");
            }
        }
        // for upadate an user
        if (isset($_POST["id"]) && isset($_POST["nom_u"]) && isset($_POST["prenom_u"]) && isset($_POST["id_role"]) && isset($_POST["email_u"])) {
            $id_u = htmlspecialchars($_POST["id"]);
            $nom_u = htmlspecialchars($_POST["nom_u"]);
            $prenom_u = htmlspecialchars($_POST["prenom_u"]);
            $id_role = htmlspecialchars($_POST["id_role"]);
            $email_u = htmlspecialchars($_POST["email_u"]);
            try {
                $userDataAccess->updateUser($id_u, $nom_u, $prenom_u, $id_role, $email_u);
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

    case "enable":
        if ($_GET["id"] != 2) {
            $users = $userDataAccess->handleFilter("id_u-ASC");
            include "./views/user/v_enableUser.php";
            include "./views/user/v_user.php";
        } else {
            setcookie("errorMessage", "L'administrateur ne peut être activé", time() + (100000), "/");
            header("Location: index.php?uc=user&action=view");
        }
        break;
}
