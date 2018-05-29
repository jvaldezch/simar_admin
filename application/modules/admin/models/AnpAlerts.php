<?php

class Admin_Model_AnpAlerts {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_AnpAlerts();
    }

    public function obtener() {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order("region ASC");
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
