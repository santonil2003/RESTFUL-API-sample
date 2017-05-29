<?php
/**
 * route
 */
class CoffeeReviews
{
    private $_table = 'coffee_reviews';

    public function fetchAll()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM $this->_table");
        return $stmt->fetchAll();
    }

    public function fetch($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM $this->_table WHERE id = ?");
        $stmt->execute(array($id));
        return $stmt->fetch();
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
