<?php
require("./vues/v_head.php");
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === 'home') {
        include 'vues/v_home.php';
    } elseif ($page === 'signup') {
        include 'vues/v_signup.php';
    } else {
        include 'pages/erreur.php';
    }
} else {
    include 'vues/v_signin.php';
}
require("./vues/v_foot.php");
