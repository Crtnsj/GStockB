<?php

class Stock
{
    private $db;

    /**
     * Constructor for the User class.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get stocks from the database.
     *
     * @param string $column The column to sort the stocks by.
     * @param string $order The order ('ASC' or 'DESC') to sort the stocks.
     * 
     * @return array An array containing the stocks retrieved from the database.
     */
    private function getStocks($column, $order)
    {
        $validColumns = ['id_st', 'nom_st', 'description_st', 'quantite_st', 'type_st'];

        // Verification of a valid column
        if (!in_array($column, $validColumns)) {
            $_SESSION['messageBox'] = "errorStock";
        }

        // Verification of a valid order
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            $_SESSION['messageBox'] = "errorStock";
        }

        $query = "SELECT * FROM stocks ORDER BY $column $order, id_st DESC";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Get a stock by its ID.
     *
     * @param int $id_st The ID of the stock to retrieve.
     * 
     * @return object The stock object retrieved from the database.
     */
    public function getStockByID($id_st)
    {
        $query = "SELECT * FROM stocks WHERE id_st = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $result = $this->db->resultSet();
        return $result[0];
    }

    /**
     * Create a new stock.
     *
     * @param string $nom_st The name of the stock.
     * @param string $description_st The description of the stock.
     * @param int $quantite_st The quantity of the stock.
     * @param string $type_st The type of the stock.
     * 
     * @return void
     */
    public function createStock($nom_st, $description_st, $quantite_st, $type_st)
    {
        $query = "INSERT INTO `stocks` (`id_st`, `nom_st`, `description_st`, `quantite_st`, `type_st`) VALUES (NULL, :nom_st, :description_st, :quantite_st, :type_st);";
        $this->db->query($query);
        $this->db->bind(':nom_st', $nom_st);
        $this->db->bind(':description_st', $description_st);
        $this->db->bind(':quantite_st', $quantite_st);
        $this->db->bind(':type_st', $type_st);
        $this->db->execute();
    }

    /**
     * Delete a stock by its ID.
     *
     * @param int $id_st The ID of the stock to delete.
     * 
     * @return void
     */
    public function deleteStock($id_st)
    {
        $query = "DELETE FROM stocks WHERE `stocks`.`id_st` = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $this->db->execute();
    }

    /**
     * Update a stock.
     *
     * @param int $id_st The ID of the stock to update.
     * @param string $nom_st The updated name of the stock.
     * @param string $description_st The updated description of the stock.
     * @param string $type_st The updated type of the stock.
     * 
     * @return void
     */
    public function updateStock($id_st, $nom_st, $description_st, $type_st)
    {
        $query = "UPDATE `stocks` SET `nom_st` = :nom_st, `description_st` = :description_st, `type_st` = :type_st WHERE `stocks`.`id_st` = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $this->db->bind(':nom_st', $nom_st);
        $this->db->bind(':description_st', $description_st);
        $this->db->bind(':type_st', $type_st);
        $this->db->execute();
    }


    /**
     * Get the names of all stocks.
     *
     * @return array An array containing the names of all stocks.
     */
    public function getStocksNames()
    {
        $query = "SELECT nom_st FROM stocks ORDER BY nom_st ASC";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Translate a stock name to its corresponding ID.
     *
     * @param string $nom_st The name of the stock.
     * @return int The ID of the stock.
     */
    public function translateNameToID($nom_st)
    {
        $query = "SELECT id_st FROM stocks WHERE `stocks`.`nom_st` = :nom_st";
        $this->db->query($query);
        $this->db->bind(':nom_st', $nom_st);
        $result = $this->db->resultSet();
        return $result[0]->id_st;
    }

    /**
     * Translate a stock ID to its corresponding name.
     *
     * @param int $id_st The ID of the stock.
     * @return string The name of the stock.
     */
    public function translateIDToName($id_st)
    {
        $query = "SELECT nom_st FROM stocks WHERE `stocks`.`id_st` = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $result = $this->db->resultSet();
        return $result[0]->nom_st;
    }

    /**
     * Compare if there are identical stocks in the selected stocks array.
     *
     * @param array $selectedStocks An array of selected stocks.
     * @return bool True if there are identical stocks, false otherwise.
     */
    public function compareIdenticalStock($selectedStocks)
    {
        $uniqueStocks = array_unique($selectedStocks);
        return count($uniqueStocks) !== count($selectedStocks);
    }

    /**
     * Get the quantity of a stock by its ID.
     *
     * @param int $id_st The ID of the stock.
     * @return array An array containing the quantity of the stock.
     */
    public function getQteOfStock($id_st)
    {
        $query = "SELECT quantite_st FROM stocks WHERE id_st = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $result = $this->db->resultSet();
        return $result;
    }

    public function updateQteOfStock($orderDetails, $type_co)
    {
        foreach ($orderDetails as $orderDetail) {
            if ($type_co == "entrée") {
                $qteOfStock = $this->getQteOfStock($orderDetail->id_st);
                $finalQte = $qteOfStock[0]->quantite_st + $orderDetail->quantite_details;
                $query = "UPDATE `stocks` SET `quantite_st` = :quantite_st WHERE `stocks`.`id_st` = :id_st";
                $this->db->query($query);
                $this->db->bind(':id_st', $orderDetail->id_st);
                $this->db->bind(':quantite_st', $finalQte);
                $this->db->execute();
                return true;
            } else if ($type_co == "sortie") {
                $qteOfStock = $this->getQteOfStock($orderDetail->id_st)[0]->quantite_st;
                if ($qteOfStock > $orderDetail->quantite_details) {
                    $finalQte = $qteOfStock[0]->quantite_st - $orderDetail->quantite_details;
                    $query = "UPDATE `stocks` SET `quantite_st` = :quantite_st WHERE `stocks`.`id_st` = :id_st";
                    $this->db->query($query);
                    $this->db->bind(':id_st', $orderDetail->id_st);
                    $this->db->bind(':quantite_st', $finalQte);
                    $this->db->execute();
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * Handle the filter for retrieving stocks based on the given filter.
     *
     * @param string $filter The filter to apply.
     * 
     * @return array An array of stocks that match the filter.
     */
    public function handleFilter($filter)
    {
        $whatWanted = explode("-", $filter);
        $stocks = $this->getStocks($whatWanted[0], $whatWanted[1]);

        return $stocks;
    }

    /**
     * Get the total number of stocks.
     *
     * @return int The total number of stocks.
     */
    public function getNumberOfStock()
    {
        $query = "SELECT id_st FROM stocks";
        $this->db->query($query);
        $queryResult = $this->db->resultSet();
        $result = count($queryResult);
        return $result;
    }

    /**
     * Get the popular stocks based on the number of times they appear in the details_commande table.
     *
     * @return array An array of popular stocks.
     */
    public function getPopularStocks()
    {
        $query = "SELECT id_st, COUNT(id_st) AS count FROM details_commande GROUP BY id_st ORDER BY count DESC LIMIT 15";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Get the stocks with the lowest quantity.
     *
     * @return array An array of stocks with the lowest quantity.
     */
    public function getLowStocks()
    {
        $query = "SELECT id_st, quantite_st FROM stocks GROUP BY id_st ORDER BY quantite_st ASC LIMIT 15";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }
}
