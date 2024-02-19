<?php


$user = new User();

$action = $_GET["action"];

switch ($action) {
    default:
        include "/views/v_error.php";
        break;
    case "validForm":
        $login = $user->login(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
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
