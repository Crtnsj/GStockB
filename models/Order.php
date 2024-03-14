<?php

class Order
{
    private $db;

    /**
     * Constructor for the Order Class
     */
    public function __construct()
    {
        $this->db = new Database();
    }
    /**
     * Fetches all orders with a specific order.
     *
     * @param string $column The name of the column.
     * @param int    $order  The order sense. Possible values: ASC for ascending, DESC for descending.
     *
     * @return array An array representing the retrieved orders. Each element is an associative array representing an order.
     *
     * @throws Exception if an invalid column or order sense is provided.
     */
    private function getOrders($column, $order)
    {
        $validColumns = ['id_co', 'date_co', 'statut_co', 'type_co', 'id_u'];

        // Vérification de la colonne valide
        if (!in_array($column, $validColumns)) {
            $_SESSION['messageBox'] = "errorStock";
        }

        // Vérification de l'ordre valide
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            $_SESSION['messageBox'] = "errorStock";
        }

        $query = "SELECT * FROM commandes ORDER BY $column $order";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }
    /**
     * Create an order.
     *
     * @param string $type_co   The type of the order. Possible values: entrée, sortie.
     * @param string $date_co   The date of the order. The format is : Y-m-d H:i:s .
     * @param int $id_u         The ID of the order requestor.
     *
     * @return void
     */
    public function createOrder($type_co, $date_co, $id_u)
    {
        $query = "INSERT INTO `commandes` (`id_co`, `date_co`, `statut_co`, `type_co`, `id_u`) VALUES (NULL, :date_co, 'en_attente', :type_co, :id_u);";
        $this->db->query($query);
        $this->db->bind(':type_co', $type_co);
        $this->db->bind(':date_co', $date_co);
        $this->db->bind(':id_u', $id_u);
        $this->db->execute();
    }
    /**
     * Get an order with her creation date. Need the id of the
     * requestor order for a better precision
     *
     * @param string $date_co   The date of the order. The format is : Y-m-d H:i:s .
     * @param int $id_u         The ID of the order requestor.
     *
     * @return void
     */
    public function getOrderByDate($date_co, $id_u)
    {
        $query = "SELECT id_co FROM commandes WHERE date_co = :date_co AND id_u = :id_u;";
        $this->db->query($query);
        $this->db->bind(':date_co', $date_co);
        $this->db->bind(':id_u', $id_u);
        $result = $this->db->resultSet();
        return $result[0]->id_co;
    }
    /**
     * Create the details of an order
     *
     * @param int $id_co    The id of the order
     * @param int $id_st    The ID of the stock
     * @param int $qte      The quantity
     * 
     * @return void
     */
    public function createOrderDetails($id_co, $id_st, $qte)
    {
        $query = "INSERT INTO `details_commande` (`id_co`, `id_st`, `quantite_details`) VALUES (:id_co, :id_st, :qte);";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $this->db->bind(':id_st', $id_st);
        $this->db->bind(':qte', $qte);
        $this->db->execute();
    }
    /**
     * Validate an order
     *
     * @param int $id_co ID of the order
     * 
     * @return void
     */
    public function validOrder($id_co)
    {
        $query = "UPDATE commandes SET statut_co = 'validee' WHERE id_co = :id_co";
        $this->db->query($query);
        $this->db->bind('id_co', $id_co);
        $this->db->execute();
    }
    /**
     * Get the details of an order.
     *
     * @param int $id_co ID of the order
     * 
     * @return array An array containing the details of the order.
     */
    public function getOrdersDetails($id_co)
    {
        $query = "SELECT id_st, quantite_details FROM details_commande WHERE id_co = :id_co;";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $result = $this->db->resultSet();
        $orderDetails = [];
        $stockDataAccess = new Stock();
        for ($i = 0; $i < count($result); $i++) {
            $orderDetail = new stdClass();
            $orderDetail->id_st = $result[$i]->id_st;
            $orderDetail->nom_st = $stockDataAccess->translateIDToName($result[$i]->id_st);
            $orderDetail->quantite_details = $result[$i]->quantite_details;
            $orderDetails[] = $orderDetail;
        }
        return $orderDetails;
    }
    /**
     * Get the type of an order
     *
     * @param int $id_co ID of the order
     * 
     * @return string The type of the order. Possible results : entrée, sortie;
     */
    public function getTypeCo($id_co)
    {
        $query = "SELECT type_co FROM commandes WHERE id_co = :id_co ;";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $result = $this->db->resultSet();
        return $result[0]->type_co;
    }
    /**
     * Handle a filter for retrieving orders.
     *
     * @param string $filter The filter string in the format "column-order".
     *
     * @return array An array of orders matching the filter criteria.
     */
    public function handleFilter($filter)
    {
        $whatWanted = explode("-", $filter);
        $orders = $this->getOrders($whatWanted[0], $whatWanted[1]);

        return $orders;
    }
    /**
     * Get the count of orders awaiting validation.
     *
     * @return int The count of orders awaiting validation.
     */
    public function getNumberOfOrderValidation()
    {
        $query = "SELECT id_co FROM commandes WHERE statut_co = 'en_attente';";
        $this->db->query($query);
        $queryResult = $this->db->resultSet();
        $result = count($queryResult);
        return $result;
    }

    /**
     * Get the total count of orders.
     *
     * @return int The total count of orders.
     */
    public function getNumberOfOrder()
    {
        $query = "SELECT id_co FROM commandes";
        $this->db->query($query);
        $queryResult = $this->db->resultSet();
        $result = count($queryResult);
        return $result;
    }
    /**
     * Get the last 10 orders sorted by date.
     *
     * @return array An array containing the last 10 orders sorted by date.
     */
    public function getLastOrders()
    {
        $query = "SELECT id_co, date_co FROM commandes ORDER BY date_co ASC LIMIT 10";
        $this->db->query($query);
        $result = $this->db->resultSet();
        return $result;
    }
    public function getStatut($id_co)
    {
        $query = "SELECT statut_co FROM commandes WHERE `id_co` = :id_co";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $result = $this->db->resultSet();
        return $result[0]->statut_co;
    }
    private function deleteOrdersDetails($id_co)
    {
        $query = "DELETE FROM details_commande WHERE `details_commande`.`id_co` = :id_co ";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $this->db->execute();
    }
    public function rejectOrder($id_co)
    {
        self::deleteOrdersDetails($id_co);
        $query = "DELETE FROM commandes WHERE `commandes`.`id_co` = :id_co";
        $this->db->query($query);
        $this->db->bind(':id_co', $id_co);
        $this->db->execute();
    }
}
