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
    function getUsers($column, $order)
    {
        $validColumns = ['id_u', 'nom_u', 'prenom_u', 'email_u', 'id_role'];

        // Vérification de la colonne valide
        if (!in_array($column, $validColumns)) {
            $_SESSION['messageBox'] = "errorStock";
        }

        // Vérification de l'ordre valide
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            $_SESSION['messageBox'] = "errorUSer";
        }

        $query = "SELECT id_u, nom_u, prenom_u, email_u, id_role FROM utilisateurs ORDER BY $column $order";
        $this->db->query($query);
        $result = $this->db->resultSet();

        return $result;
    }

    function handleFilter($filter)
    {
        $whatWanted = explode("-", $filter);
        $users = $this->getUsers($whatWanted[0], $whatWanted[1]);
        return $users;
    }
    function getNumberOfUser()
    {
        $query = "SELECT id_u FROM utilisateurs";
        $this->db->query($query);
        $queryResult = $this->db->resultSet();
        $result = count($queryResult);
        return $result;
    }
}
