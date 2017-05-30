<?php

/**
 * route
 */
class CoffeeReviews extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    /**
     * set table name
     * @return type
     */
    public function setTableName() {
        return $this->_table = "coffee_reviews";
    }

    /**
     * fetchr reviews by coffee id
     * @param type $coffeeId
     * @return type
     */
    public function fetchByCoffee($coffeeId) {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->_table WHERE coffee_id = ?");
        $stmt->execute(array($coffeeId));
        return $stmt->fetchAll();
    }

    /**
     * get average rating by coffee id
     * @param type $coffeeId
     * @return type
     */
    public function getAverageRatingByCoffee($coffeeId) {
        $stmt = $this->pdo->prepare("SELECT IFNULL(ROUND(AVG(rating),2), ' - ') as rating FROM $this->_table WHERE coffee_id = ?");
        $stmt->execute(array($coffeeId));
        return $stmt->fetchColumn();
    }

}
