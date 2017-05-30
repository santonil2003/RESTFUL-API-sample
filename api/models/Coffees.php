<?php

/**
 * Coffees model
 */
class Coffees extends BaseModel {
    /*
     * construct
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * set table name
     * @return type
     */
    public function setTableName() {
        return $this->_table = "coffees";
    }

    /**
     * getch coffees with average rating
     * @return type
     */
    public function coffeesWithAverageRating($orderBy = 'c.name') {
        $stmt = $this->pdo->query("SELECT c.*, IFNULL((SELECT ROUND(AVG(cr.rating),2) FROM coffee_reviews as cr WHERE cr.coffee_id = c.id), '-') as rating FROM coffees as c ORDER BY $orderBy");
        return $stmt->fetchAll();
    }

}
