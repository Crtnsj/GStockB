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
    function getStocks($column, $order = 'ASC')
    {
        $validColumns = ['id_st', 'nom_st', 'description_st', 'quantite_st', 'type_st'];

        // Vérification de la colonne valide
        if (!in_array($column, $validColumns)) {
            $_SESSION['messageBox'] = "errorStock";
        }

        // Vérification de l'ordre valide
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            $_SESSION['messageBox'] = "errorStock";
        }

        $query = "SELECT * FROM stocks ORDER BY $column $order";
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
        return $result[0];
    }
    function createStock($nom_st, $description_st, $quantite_st, $type_st)
    {
        $query = "INSERT INTO `stocks` (`id_st`, `nom_st`, `description_st`, `quantite_st`, `type_st`) VALUES (NULL, :nom_st, :description_st, :quantite_st, :type_st);";
        $this->db->query($query);
        $this->db->bind(':nom_st', $nom_st);
        $this->db->bind(':description_st', $description_st);
        $this->db->bind(':quantite_st', $quantite_st);
        $this->db->bind(':type_st', $type_st);
        $this->db->execute();
    }
    //supprime un stock
    function deleteStock($id_st)
    {
        $query = "DELETE FROM stocks WHERE `stocks`.`id_st` = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $this->db->execute();
    }


    function updateStock($id_st, $nom_st, $description_st, $type_st)
    {
        $query = "UPDATE `stocks` SET `nom_st` = :nom_st, `description_st` = :description_st, `type_st` = :type_st WHERE `stocks`.`id_st` = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $this->db->bind(':nom_st', $nom_st);
        $this->db->bind(':description_st', $description_st);
        $this->db->bind(':type_st', $type_st);
        $this->db->execute();
    }


    function getStocksNames()
    {

        $query = "SELECT nom_st FROM stocks";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }
    function translateNameToID($nom_st)
    {
        $query = "SELECT id_st FROM stocks WHERE `stocks`.`nom_st` = :nom_st";
        $this->db->query($query);
        $this->db->bind(':nom_st', $nom_st);
        $result = $this->db->resultSet();
        return $result[0]->id_st;
    }
    function compareIdenticalStock($selectedStocks)
    {
        $uniqueStocks = array_unique($selectedStocks);
        return count($uniqueStocks) !== count($selectedStocks);
    }
    function getQteOfStock($id_st)
    {
        $query = "SELECT quantite_st FROM stocks WHERE id_st = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $result = $this->db->resultSet();
        return $result;
    }
    function updateQteOfStock($id_st, $quantite_details, $type_co)
    {
        if ($type_co == "entrée") {
            $qteOfStock = $this->getQteOfStock($id_st);
            $finalQte = $qteOfStock[0]->quantite_st + $quantite_details;
            $query = "UPDATE `stocks` SET `quantite_st` = :quantite_st WHERE `stocks`.`id_st` = :id_st";
            $this->db->query($query);
            $this->db->bind(':id_st', $id_st);
            $this->db->bind(':quantite_st', $finalQte);
            $this->db->execute();
        } else if ($type_co == "sortie") {
            $qteOfStock = $this->getQteOfStock($id_st);
            if ($qteOfStock > $quantite_details) {
                $finalQte = $qteOfStock[0]->quantite_st - $quantite_details;
                $query = "UPDATE `stocks` SET `quantite_st` = :quantite_st WHERE `stocks`.`id_st` = :id_st";
                $this->db->query($query);
                $this->db->bind(':id_st', $id_st);
                $this->db->bind(':quantite_st', $finalQte);
                $this->db->execute();
            } else {
                $_SESSION['messageBox'] = "errorStock"; //todo handle message
            }
        }
    }
    function handleFilter($filter)
    {
        $whatWanted = explode("-", $filter);
        $stocks = $this->getStocks($whatWanted[0], $whatWanted[1]);

        return $stocks;
    }
}
