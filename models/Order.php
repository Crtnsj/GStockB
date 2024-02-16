<?php
include("./core/database/pdo.php");
$db = new Database();
class Order
{
    function getOrders()
    {
        global $db;
        $sql = "SELECT * FROM commandes";
        $db->query($sql);
        $result = $db->resultSet();
        return $result;
    }
    function createOrder($type_co)
    {
        global $db;
        $id_u = 2;
        $date_co = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `commandes` (`id_co`, `date_co`, `statut_co`, `type_co`, `id_u`) VALUES (NULL, :date_co, 'en_attente', :type_co, :id_u);";
        $db->query($sql);
        $db->bind(':type_co', $type_co);
        $db->bind(':date_co', $date_co);
        $db->bind(':id_u', $id_u);

        $db->execute();
    }
}
