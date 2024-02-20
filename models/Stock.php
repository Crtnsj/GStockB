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
        $query = "SELECT * FROM stocks";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }
    function getStockByID($id_st)
    {
        $query = "SELECT * FROM stocks WHERE id_st = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $result = $this->db->resultSet();
        return $result;
    }
    //supprime un stock
    function deleteStock($id_st)
    {
        $query = "DELETE FROM stocks WHERE `stocks`.`id_st` = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $this->db->execute();
    }
    function updateStock($id_st, $nom_st, $description_st, $quantite_st, $type_st)
    {
        $query = "UPDATE `stocks` SET `nom_st` = :nom_st, `description_st` = :description_st, `quantite_st` = :quantite_st, `type_st` = :type_st WHERE `stocks`.`id_st` = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $this->db->bind(':nom_st', $nom_st);
        $this->db->bind(':description_st', $description_st);
        $this->db->bind(':quantite_st', $quantite_st);
        $this->db->bind(':type_st', $type_st);
        $this->db->execute();
    }
}
