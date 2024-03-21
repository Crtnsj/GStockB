<?php

class Database
{
    private $host = 'localhost'; // Database server address
    private $dbname = 'GStockB'; // Database name
    private $username = 'root'; // Username for database connection
    private $password = ''; // Password for database connection
    private $dbHandler; // PDO connection handler
    private $statement; // PDO prepared statement
    private $error; // Error message in case of connection failure or query errors

    /**
     * Constructor method.
     * Establishes a connection to the database using PDO.
     */
    public function __construct()
    {
        //créer la chaine de connexion
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            //créer un nouvel objet PDO avec les informations de connexions et les parametres 
            //neccessaires
            $this->dbHandler = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Executes a database query.
     * Prepares the statement and returns it.
     *
     * @param string $sql The SQL query to execute.
     * @return PDOStatement The prepared statement.
     */
    public function query($sql)
    {
        return $this->statement = $this->dbHandler->prepare($sql);
    }

    /**
     * Binds a value to a parameter in the prepared statement.
     *
     * @param string $parameter The parameter placeholder in the SQL query.
     * @param mixed $value The value to bind.
     * @param int|null $type The data type of the parameter (default: PDO::PARAM_STR).
     */
    public function bind($parameter, $value, $type = null)
    {
        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    /**
     * Executes the prepared statement.
     *
     * @return bool True on success, false on failure.
     */
    public function execute()
    {
        return $this->statement->execute();
    }

    /**
     * Fetches all rows from the result set of the executed query.
     *
     * @return array The result set as an array of objects.
     */
    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
}
