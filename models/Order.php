<?php

class Order
{
    private $db;

    /**
     * Constructor for the class user
     */
    public function __construct()
    {
        $this->db = new Database();
    }
    function getOrders()
    {
        $query = "SELECT * FROM commandes";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }
}
