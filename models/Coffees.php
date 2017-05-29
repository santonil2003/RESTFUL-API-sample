<?php
/**
 * route
 */
class Coffees
{

    private $_table = 'coffees';

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
}