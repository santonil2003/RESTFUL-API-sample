<?php
/**
 * route
 */
class CoffeeReviews extends BaseModel
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
        $stmt = $this->pdo->prepare("SELECT * FROM $this->_table WHERE coffee_id = ?");
        $stmt->execute(array($coffeeId));
        return $stmt->fetchAll();
    }

    public function getAverageRatingByCoffee($coffeeId)
    {
        $stmt = $this->pdo->prepare("SELECT ROUND(AVG(rating),2) FROM $this->_table WHERE coffee_id = ?");
        $stmt->execute(array($coffeeId));
        return $stmt->fetchColumn();
    }
}
