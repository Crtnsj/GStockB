<?php
include "../api/pdo.php";
$db = new Database();

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
}
