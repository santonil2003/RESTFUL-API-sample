<?php
/**
 * route
 */
class Coffees extends Queries
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setTableName()
    {
        return $this->_table = "coffees";
    }

}
