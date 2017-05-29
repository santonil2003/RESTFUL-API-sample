<?php
/**
 * route
 */
class Coffees extends BaseModel
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
