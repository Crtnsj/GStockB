<div class="logPage">
    <div class="logBox">
        <div class="logForm">
            <?php
            $state = true;

            if (!$state) {
                include("./vues/v_signin.php");
            } else {
                include("./vues/v_signup.php");
            }
            // if ($state) {
            //     return(<a>creer un compte<a/>)
            // } else {
            //     include(<a>Se connecter</a>);
            // }
            // 
            ?>

        </div>
        <div>LOGO</div>
    </div>
</div>