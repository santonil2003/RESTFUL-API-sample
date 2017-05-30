<?php

/**
 * base model
 */
abstract class BaseModel {

    /**
     * table name
     * @var type 
     */
    protected $_table;

    /**
     * pdo oject
     * @var type 
     */
    public $pdo;

    /**
     * set table name
     */
    abstract protected function setTableName();

    public function __construct() {

        if (!is_object($this->pdo)) {
            global $pdo;
            $this->pdo = $pdo;
        }

        $this->setTableName();
    }

    /**
     * get columns by table name
     * @return type
     */
    public function getColumns() {

        $stmt = $this->pdo->query("SHOW COLUMNS FROM  $this->_table");
        $rows = $stmt->fetchAll();
        return array_column($rows, 'Field');
    }

    /**
     * fetch all rows
     * @return type
     */
    public function fetchAll() {

        $stmt = $this->pdo->query("SELECT * FROM $this->_table");
        return $stmt->fetchAll();
    }

    /**
     * fetch one row by primary key
     * @param type $id
     * @return type
     */
    public function fetch($id) {

        $stmt = $this->pdo->prepare("SELECT * FROM $this->_table WHERE id = ?");
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    /**
     * insert a row
     * @param type $data
     * @return type
     */
    public function create($data) {

        $columns = $this->getColumns();

        // clear unnecessary data
        foreach ($data as $key => $value) {
            if (!in_array($key, $columns)) {
                unset($data[$key]);
            }
        }

        $keys = array_keys($data);
        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);

        $result = $this->pdo->prepare("INSERT INTO `$this->_table`($fields) VALUES($placeholder)")->execute(array_values($data));

        if ($result) {
            return $this->pdo->lastInsertId();
        }
    }

    /**
     * update a row
     * @param type $data
     * @param type $id
     * @return type
     */
    public function update($data, $id) {

        $columns = $this->getColumns();

        // clear unnecessary data
        foreach ($data as $key => $value) {
            if (!in_array($key, $columns)) {
                unset($data[$key]);
            }
        }

        // prepare update query
        $sql = "UPDATE $this->_table SET ";
        $values = array(':id' => $id);
        foreach ($data as $name => $value) {
            $sql .= ' ' . $name . ' = :' . $name . ',';
            $values[':' . $name] = $value;
        }
        $sql = substr($sql, 0, -1); // remove last ,
        $sql .= ' WHERE id = :id ;';

        return $this->pdo->prepare($sql)->execute($values);
    }

    /**
     * delete a row
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM $this->_table WHERE id = ?");
        return $stmt->execute(array($id));
    }

}
