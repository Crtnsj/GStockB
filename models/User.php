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
        $query = "SELECT `id_u`,`mot_de_passe`,`id_role` FROM utilisateurs WHERE email_u = :email";
        $this->db->query($query);
        $this->db->bind(':email', $email);
        $result = $this->db->resultSet();
        if ($result) {
            $user = $result[0];
            if (password_verify($password, $user->mot_de_passe)) {
                $_SESSION['id_u'] = $user->id_u;
                $_SESSION['id_role'] = $user->id_role;

                return true;
            } else {
                return false;
            }
        } else {
            $_SESSION["messageBox"] = "loginError"; //todo : handle messages
        }
    }
}
