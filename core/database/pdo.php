<?php
class Database
{
    private $host = 'localhost';
    private $dbname = 'GStockB';
    private $username = 'root';
    private $password = '';
    private $dbHandler; // destine a contenir la connexion a la base de donnees (une instance de pdo)
    private $statement;
    private $error;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a new PDO instance
        try {
            $this->dbHandler = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function  query($sql)
    {
        return $this->statement = $this->dbHandler->prepare($sql);
    }

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

    public function execute()
    {
        return $this->statement->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
}
