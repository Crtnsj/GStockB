<?php



// $userDataAccess = new User();

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
        //for authentication 
        else {
            try {
                $login = $userDataAccess->login(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
                if ($login) {
                    header("location: ./index.php?uc=home");
                } else {
                    $userDataAccess->writeLog($_POST["email"] . "a échoué la connexion", 'loginErrorLogs.log');
                    setcookie("errorMessage", "Identifiants invalides", time() + (100000), "/");
                    header("location: ./index.php");
                }
            } catch (Exception $e) {
                $userDataAccess->writeLog($e, 'userErrorLogs.log');
                setcookie("errorMessage", "Une erreur s'est produite", time() + (100000), "/");
            }
        }

        break;

    case "disconnect":
        //remove session's data
        $_SESSION = array();
        //destruction of session
        session_destroy();
        //redirect to login page
        header("Location: index.php");
        break;
}
