<?php

class User
{
    public $id;
    public $lastname;
    public $firstname;
    public $email;
    public $password;
    public $role;



    private $db;

    /**
     * Constructor for the class user
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    function login($email, $password)
    {
        $query = "SELECT `id_u`,`mot_de_passe` FROM utilisateurs WHERE email_u = :email";
        $this->db->query($query);
        $this->db->bind(':email', $email);
        $result = $this->db->resultSet();
        if ($result) {
            $user = $result[0];
            if (password_verify($password, $user->mot_de_passe)) {
                $_SESSION['id_u'] = $user->id_u;
                header("location: ./index.php?uc=home");
                exit();
            } else {
                $_SESSION["messageBox"] = "loginError";
            }
        } else {
            $_SESSION["messageBox"] = "loginError";
        }
    }
}
