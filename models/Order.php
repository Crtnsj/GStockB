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
    function createOrder($type_co, $date_co, $id_u)
    {
        $query = "INSERT INTO `commandes` (`id_co`, `date_co`, `statut_co`, `type_co`, `id_u`) VALUES (NULL, :date_co, 'en_attente', :type_co, :id_u);";
        $this->db->query($query);
        $this->db->bind(':type_co', $type_co);
        $this->db->bind(':date_co', $date_co);
        $this->db->bind(':id_u', $id_u);
        $this->db->execute();
    }
    function getOrderByDate($date_co, $id_u)
    {
        $query = "SELECT id_co FROM commandes WHERE date_co = :date_co AND id_u = :id_u;";
        $this->db->query($query);
        $this->db->bind(':date_co', $date_co);
        $this->db->bind(':id_u', $id_u);
        $result = $this->db->resultSet();
        return $result[0]->id_co;
    }
    function createOrderDetails($id_co, $id_st, $qte)
    {
        $query = "INSERT INTO `details_commande` (`id_co`, `id_st`, `quantite_details`) VALUES (:id_co, :id_st, :qte);";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $this->db->bind(':id_st', $id_st);
        $this->db->bind(':qte', $qte);
        $this->db->execute();
    }
    function validOrder($id_co)
    {
        $query = "UPDATE commandes SET statut_co = 'validee' WHERE id_co = :id_co";
        $this->db->query($query);
        $this->db->bind('id_co', $id_co);
        $this->db->execute();
    }
    function getOrdersDetails($id_co)
    {
        $query = "SELECT id_st, quantite_details FROM details_commande WHERE id_co = :id_co ;";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $result = $this->db->resultSet();
        return $result;
    }
    function getTypeCo($id_co)
    {
        $query = "SELECT type_co FROM commandes WHERE id_co = :id_co ;";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $result = $this->db->resultSet();
        return $result[0]->type_co;
    }
}
