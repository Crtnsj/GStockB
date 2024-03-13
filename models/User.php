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
        $validColumns = ['id_u', 'nom_u', 'prenom_u', 'email_u', 'id_role', 'active'];

        // Vérification de la colonne valide
        if (!in_array($column, $validColumns)) {
            $_SESSION['messageBox'] = "errorStock";
        }

        // Vérification de l'ordre valide
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            $_SESSION['messageBox'] = "errorUSer";
        }

        $query = "SELECT id_u, nom_u, prenom_u, email_u, active, id_role FROM utilisateurs ORDER BY $column $order";
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
    function createUSer($nom_u, $prenom_u, $email_u, $mot_de_passe, $id_role)
    {
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $query = "INSERT INTO `utilisateurs` (`id_u`, `nom_u`, `prenom_u`, `email_u`, `mot_de_passe`, `id_role`) VALUES (NULL, :nom_u, :prenom_u, :email_u, :hash, :id_role);";
        $this->db->query($query);
        $this->db->bind(':nom_u', $nom_u);
        $this->db->bind(':prenom_u', $prenom_u);
        $this->db->bind(':email_u', $email_u);
        $this->db->bind(':id_role', $id_role);
        $this->db->bind(':hash', $hash);
        $this->db->execute();
    }
    function writeLog($message, $filename)
    {
        // !! important, you must have rights to the target directory
        $logMessage = date('[Y-m-d H:i:s]') . ' ' . $message . PHP_EOL;
        $outputFile = __DIR__ . '/../logs/' . $filename;
        file_put_contents($outputFile, $logMessage, FILE_APPEND);
    }
    function disableUser($id_u)
    {
        $query = "UPDATE `utilisateurs` SET `active` = '2' WHERE `utilisateurs`.`id_u` = :id_u;";
        $this->db->query($query);
        $this->db->bind(':id_u', $id_u);
        $this->db->execute();
    }
}
