<?php

class Stock
{
    private $db;

    /**
     * Constructor for the class user
     */
    public function __construct()
    {
        $this->db = new Database();
    }
    function getStocks()
    {
        $sql = "SELECT * FROM stocks";
        $this->db->query($sql);
        $result = $this->db->resultSet();
        return $result;
    }
}
