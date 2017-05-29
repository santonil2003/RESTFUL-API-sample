<?php
/**
 * route
 */
class CoffeeReviews extends Queries
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setTableName()
    {
        return $this->_table = "coffee_reviews";
    }

    public function fetchByCoffee($coffeeId)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM $this->_table WHERE coffee_id = ?");
        $stmt->execute(array($coffeeId));
        return $stmt->fetchAll();
    }

    public function getAverageRatingByCoffee($coffeeId)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT AVG(rating) FROM $this->_table WHERE coffee_id = ?");
        $stmt->execute(array($coffeeId));
        return $stmt->fetchColumn();
    }
}
