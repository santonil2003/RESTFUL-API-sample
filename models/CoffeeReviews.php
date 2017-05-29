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

    public function create($data)
    {
        global $pdo;
        $keys        = array_keys($data);
        $fields      = '`' . implode('`, `', $keys) . '`';
        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);
        return $pdo->prepare("INSERT INTO `$this->_table`($fields) VALUES($placeholder)")->execute(array_values($data));
    }

    public function update($data, $id)
    {
        global $pdo;

        // prepare update query
        $sql    = "UPDATE $this->_table SET ";
        $values = array(':id' => $id);
        foreach ($data as $name => $value) {
            $sql .= ' ' . $name . ' = :' . $name . ',';
            $values[':' . $name] = $value;
        }
        $sql = substr($sql, 0, -1); // remove last ,
        $sql .= ' WHERE id = :id ;';

        return $pdo->prepare($sql)->execute($values);
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
