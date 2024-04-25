<?php

class User
{

    private $db;

    /**
     * Constructor for the User class.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Logs in a user with the given email and password.
     *
     * @param string $email The email address of the user.
     * @param string $password The password of the user.
     * 
     * @return bool True if the login is successful, false otherwise.
     */
    public function login($email, $password)
    {
        $query = "SELECT `id_u`, `mot_de_passe`, `id_role`, `active` FROM utilisateurs WHERE email_u = :email";
        $this->db->query($query);
        $this->db->bind(':email', $email);
        $result = $this->db->resultSet();
        if ($result) {
            $user = $result[0];
            if (password_verify($password, $user->mot_de_passe) && $user->active == '1') {
                $_SESSION['id_u'] = $user->id_u;
                $_SESSION['id_role'] = $user->id_role;
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Get users based on the specified column and order.
     *
     * @param string $column The column to order the results by.
     * @param string $order The order to sort the results in (ASC or DESC).
     * 
     * @return array An array of users matching the specified column and order.
     */
    private function getUsers($column, $order)
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

    /**
     * Handle the filter for retrieving users based on the given filter.
     *
     * @param string $filter The filter to apply.
     * 
     * @return array An array of users that match the filter.
     */
    public function handleFilter($filter)
    {
        $whatWanted = explode("-", $filter);
        $users = $this->getUsers($whatWanted[0], $whatWanted[1]);
        return $users;
    }

    /**
     * Get the total number of activated users.
     *
     * @return int The total number of avtiveted users.
     */
    public function getNumberOfActivatedUser()
    {
        $query = "SELECT id_u FROM utilisateurs WHERE active= '1'";
        $this->db->query($query);
        $queryResult = $this->db->resultSet();
        $result = count($queryResult);
        return $result;
    }

    /**
     * Create a new user with the given information.
     *
     * @param string $nom_u The last name of the user.
     * @param string $prenom_u The first name of the user.
     * @param string $email_u The email address of the user.
     * @param string $mot_de_passe The password of the user.
     * @param int $id_role The ID of the role for the user.
     * 
     * @return void
     */
    public function createUser($nom_u, $prenom_u, $email_u, $mot_de_passe, $id_role)
    {
        $existingEmail = self::compareUsersEmails($email_u);
        if (!$existingEmail) {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $query = "INSERT INTO `utilisateurs` (`id_u`, `nom_u`, `prenom_u`, `email_u`, `mot_de_passe`, `id_role`) VALUES (NULL, :nom_u, :prenom_u, :email_u, :hash, :id_role);";
            $this->db->query($query);
            $this->db->bind(':nom_u', $nom_u);
            $this->db->bind(':prenom_u', $prenom_u);
            $this->db->bind(':email_u', $email_u);
            $this->db->bind(':id_role', $id_role);
            $this->db->bind(':hash', $hash);
            $this->db->execute();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Write a log message to the specified file.
     *
     * @param string $message The message to write to the log.
     * @param string $filename The name of the log file.
     * 
     * @return void
     */
    public function writeLog($message, $filename)
    {
        // !! important, you must have rights to the target directory
        $logMessage = date('[Y-m-d H:i:s]') . ' ' . $message . PHP_EOL;
        $outputFile = __DIR__ . './../../logs/' . $filename;
        file_put_contents($outputFile, $logMessage, FILE_APPEND);
    }

    /**
     * Disable an user with the specified ID.
     *
     * @param int $id_u The ID of the user to disable.
     * 
     * @return void
     */
    public function disableUser($id_u)
    {
        $query = "UPDATE `utilisateurs` SET `active` = '2' WHERE `utilisateurs`.`id_u` = :id_u;";
        $this->db->query($query);
        $this->db->bind(':id_u', $id_u);
        $this->db->execute();
    }
    /** Enable an user with the specified ID.
     *
     * @param int $id_u The ID of the user to enable.
     * 
     * @return void
     */
    public function enableUser($id_u)
    {
        $query = "UPDATE `utilisateurs` SET `active` = '1' WHERE `utilisateurs`.`id_u` = :id_u;";
        $this->db->query($query);
        $this->db->bind(':id_u', $id_u);
        $this->db->execute();
    }
    /**
     * Find if the email exist in database
     *
     * @param string $email_u The email to be compared
     * 
     * @return bool The result of the comparison
     */

    private function compareUsersEmails($email_u)
    {
        $query = "SELECT email_u FROM utilisateurs";
        $this->db->query($query);
        $result = $this->db->resultSet();
        foreach ($result as $tests) {
            if ($tests->email_u == $email_u) {
                return true;
            };
        }
        return false;
    }
    /**
     * Get a user by their ID.
     *
     * @param int $id_u The ID of the user.
     * @return object The user object containing the user's ID, name, email, and role ID.
     */
    public function getUserByID($id_u)
    {
        $query = "SELECT id_u, nom_u, prenom_u, email_u, id_role FROM utilisateurs WHERE id_u = :id_u";
        $this->db->query($query);
        $this->db->bind(':id_u', $id_u);
        $result = $this->db->resultSet();
        return $result[0];
    }

    /**
     * Update a user's information.
     *
     * @param int $id_u The ID of the user.
     * @param string $nom_u The user's last name.
     * @param string $prenom_u The user's first name.
     * @param int $id_role The ID of the user's role.
     * @param string $email_u The user's email address.
     * @return void
     */
    public function updateUser($id_u, $nom_u, $prenom_u, $id_role, $email_u)
    {
        $query = "UPDATE `utilisateurs` SET `nom_u` = :nom_u, `prenom_u` = :prenom_u, `id_role` = :id_role, `email_u`= :email_u WHERE `utilisateurs`.`id_u` = :id_u";
        $this->db->query($query);
        $this->db->bind(':id_u', $id_u);
        $this->db->bind(':nom_u', $nom_u);
        $this->db->bind(':prenom_u', $prenom_u);
        $this->db->bind(':id_role', $id_role);
        $this->db->bind(':email_u', $email_u);
        $this->db->execute();
    }

    /**
     * Update a user's password.
     *
     * @param int $id_u The ID of the user.
     * @param string $ancien_mot_de_passe The user's current password.
     * @param string $mot_de_passe The new password.
     * @return bool Returns true if the password was successfully updated, false otherwise.
     */
    public function updatePassword($id_u, $ancien_mot_de_passe, $mot_de_passe)
    {
        $verifOldPassword = self::verifOldPassword($id_u, $ancien_mot_de_passe);
        if ($verifOldPassword) {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $query = "UPDATE `utilisateurs` SET `mot_de_passe` = :hash WHERE `utilisateurs`.`id_u` = :id_u;";
            $this->db->query($query);
            $this->db->bind(':id_u', $id_u);
            $this->db->bind(':hash', $hash);
            $this->db->execute();
            return true;
        }
    }

    /**
     * Verify the user's old password.
     *
     * @param int $id_u The ID of the user.
     * @param string $password The old password to verify.
     * @return bool Returns true if the old password is verified, false otherwise.
     */
    private function verifOldPassword($id_u, $password)
    {
        $query = "SELECT `mot_de_passe` FROM utilisateurs WHERE id_u = :id_u";
        $this->db->query($query);
        $this->db->bind(':id_u', $id_u);
        $result = $this->db->resultSet();
        if ($result) {
            $user = $result[0];
            if (password_verify($password, $user->mot_de_passe)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Translate a user's ID to their email address.
     *
     * @param int $id_u The ID of the user.
     * @return string The email address of the user.
     */
    public function translateIDtoEmail($id_u)
    {
        $query = "SELECT email_u FROM utilisateurs WHERE `utilisateurs`.`id_u` = :id_u";
        $this->db->query($query);
        $this->db->bind(':id_u', $id_u);
        $result = $this->db->resultSet();
        return $result[0]->email_u;
    }
}
