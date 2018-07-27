<?php

class Admin_Model_Users {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_Users();
    }

    public function obtener($year = null, $sensor = null, $type = null) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order("name ASC");
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
