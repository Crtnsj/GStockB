<?php


$userDataAccess = new User();

$action = $_GET["action"];

switch ($action) {
    default:
        include "/views/v_error.php";
        break;
    case "view":
        if (empty($_GET["filter"])) {
            $users = $userDataAccess->handleFilter("id_u-ASC");
            include "./views/user/v_user.php";
            break;
        } else {
            $filter = $_GET["filter"];
            $users = $userDataAccess->handleFilter($filter);
            $column = explode("-", $filter)[0];
            $order = explode("-", $filter)[1];
            include "./views/user/v_user.php";
        }
        break;
    case "create":
        include "./views/user/v_createUser.php";
        break;
    case "validForm":
        if (isset($_POST["nom_u"]) && isset($_POST["prenom_u"])) {
            $nom_u = htmlspecialchars($_POST["nom_u"]);
            $prenom_u = htmlspecialchars($_POST["prenom_u"]);
            $id_role = htmlspecialchars($_POST["id_role"]);
            $email_u = htmlspecialchars($_POST["email_u"]);
            $mot_de_passe = htmlspecialchars($_POST["mot_de_passe"]);

            try {

                $userDataAccess->createUser($nom_u, $prenom_u, $email_u, $mot_de_passe, $id_role);
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            $login = $userDataAccess->login(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
            if ($login) {
                header("location: ./index.php?uc=home");
            }
        }

        break;
    case "disconnect":
        $_SESSION = array();

        // Destruction de la session
        session_destroy();

        // Redirection vers la page de connexion
        header("Location: index.php");
        break;
}
