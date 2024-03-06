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
    case "validForm":
        $login = $userDataAccess->login(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
        if ($login) {
            header("location: ./index.php?uc=home");
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
