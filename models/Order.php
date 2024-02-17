<?php

class Order
{
    //recupere la table commandes
    function getOrders()
    {
        global $db;
        $sql = "SELECT * FROM commandes";
        $db->query($sql);
        $result = $db->resultSet();
        return $result;
    }
    //creer une commande
    function createOrder($type_co, $date_co)
    {
        global $db;
        $id_u = 2;
        $sql = "INSERT INTO `commandes` (`id_co`, `date_co`, `statut_co`, `type_co`, `id_u`) VALUES (NULL, :date_co, 'en_attente', :type_co, :id_u);";
        $db->query($sql);
        $db->bind(':type_co', $type_co);
        $db->bind(':date_co', $date_co);
        $db->bind(':id_u', $id_u);

        $db->execute();
    }
    //supprime une commande
    function deleteOrder($id_co)
    {
        global $db;
        $sql = "DELETE FROM commandes WHERE `commandes`.`id_co` = :id_co";
        $db->query($sql);
        $db->bind(':id_co', $id_co);
        $db->execute();
    }
    //creer le detail de la commande
    function createOrderDetails($id_co, $id_st, $qte)
    {
        global $db;
        $sql = "INSERT INTO `details_commande` (`id_co`, `id_st`, `quantite_details`) VALUES (:id_co, :id_st, :qte);";
        $db->query($sql);
        $db->bind(':id_co', $id_co);
        $db->bind(':id_st', $id_st);
        $db->bind(':qte', $qte);
        $db->execute();
    }
    //trouve une commande grace a sa date de creation
    function getOrderByDate($date_co)
    {
        global $db;
        $sql = "SELECT id_co FROM commandes WHERE date_co = :date_co;";
        $db->query($sql);
        $db->bind(':date_co', $date_co);
        $result = $db->resultSet();
        return $result;
    }
    function getDetails($id_co)
    {
        global $db;
        $sql = "SELECT * FROM details_commande WHERE id_co = :id_co;";
        $db->query($sql);
        $db->bind(':id_co', $id_co);
        $result = $db->resultSet();
        return $result;
    }
}
