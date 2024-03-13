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
    function getStocks($column, $order)
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

        $query = "SELECT * FROM stocks ORDER BY $column $order";
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
    function getStockByID($id_st)
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

    /**
     * Delete a stock by its ID.
     *
     * @param int $id_st The ID of the stock to delete.
     * 
     * @return void
     */
    function deleteStock($id_st)
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


    /**
     * Get the names of all stocks.
     *
     * @return array An array containing the names of all stocks.
     */
    function getStocksNames()
    {
        $query = "SELECT nom_st FROM stocks";
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
    function translateNameToID($nom_st)
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
    function translateIDToName($id_st)
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
    function compareIdenticalStock($selectedStocks)
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
    function getQteOfStock($id_st)
    {
        $query = "SELECT quantite_st FROM stocks WHERE id_st = :id_st";
        $this->db->query($query);
        $this->db->bind(':id_st', $id_st);
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Update the quantity of a stock based on the given parameters.
     *
     * @param int $id_st The ID of the stock.
     * @param int $quantite_details The quantity details to update.
     * @param string $type_co The type of the update ("entrée" or "sortie").
     * 
     * @return void
     */
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

    /**
     * Handle the filter for retrieving stocks based on the given filter.
     *
     * @param string $filter The filter to apply.
     * 
     * @return array An array of stocks that match the filter.
     */
    function handleFilter($filter)
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
    function getNumberOfStock()
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
    function getPopularStocks()
    {
        $query = "SELECT id_st, COUNT(id_st) AS count FROM details_commande GROUP BY id_st ORDER BY count DESC LIMIT 5";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Get the stocks with the lowest quantity.
     *
     * @return array An array of stocks with the lowest quantity.
     */
    function getLowStocks()
    {
        $query = "SELECT id_st, quantite_st FROM stocks GROUP BY id_st ORDER BY quantite_st ASC LIMIT 10";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }
}
