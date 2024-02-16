<?php

class Stock
{
    function getStocks()
    {
        global $db;
        $sql = "SELECT * FROM stocks";
        $db->query($sql);
        $result = $db->resultSet();
        return $result;
    }

    function createStock($nom_st, $description_st, $quantite_st, $type_st)
    {
        global $db;
        $sql = "INSERT INTO `stocks` (`id_st`, `nom_st`, `description_st`, `quantite_st`, `type_st`) VALUES (NULL, :nom_st, :description_st, :quantite_st, :type_st);";
        $db->query($sql);
        $db->bind(':nom_st', $nom_st);
        $db->bind(':description_st', $description_st);
        $db->bind(':quantite_st', $quantite_st);
        $db->bind(':type_st', $type_st);
        $db->execute();
    }
    function updateStock($id_st, $nom_st, $description_st, $quantite_st, $type_st)
    {
        global $db;
        $sql = "UPDATE `stocks` SET `nom_st` = :nom_st, `description_st` = :description_st, `quantite_st` = :quantite_st, `type_st` = :type_st WHERE `stocks`.`id_st` = :id_st";
        $db->query($sql);
        $db->bind(':id_st', $id_st);
        $db->bind(':nom_st', $nom_st);
        $db->bind(':description_st', $description_st);
        $db->bind(':quantite_st', $quantite_st);
        $db->bind(':type_st', $type_st);
        $db->execute();
    }
    function getStockByID($id_st)
    {
        global $db;
        $sql = "SELECT * FROM stocks WHERE id_st = :id_st";
        $db->query($sql);
        $db->bind(':id_st', $id_st);
        $result = $db->resultSet();
        return $result;
    }
    function deleteStock($id_st)
    {
        global $db;
        $sql = "DELETE FROM stocks WHERE `stocks`.`id_st` = :id_st";
        $db->query($sql);
        $db->bind(':id_st', $id_st);
        $db->execute();
    }
    function getStocksNames()
    {
        global $db;
        $sql = "SELECT nom_st FROM stocks";
        $db->query($sql);
        $result = $db->resultSet();
        return $result;
    }
    function translateNameToID($nom_st)
    {
        global $db;
        $sql = "SELECT id_st FROM stocks WHERE `stocks`.`nom_st` = :nom_st";
        $db->query($sql);
        $db->bind(':nom_st', $nom_st);
        $result = $db->resultSet();
        return $result;
    }
}
