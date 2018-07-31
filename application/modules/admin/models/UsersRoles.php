<?php

class Admin_Model_UsersRoles {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_UsersRoles();
    }

    public function obtener() {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order('name ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception('DB Exception found on ' . __METHOD__ . ': ' . $ex->getMessage());
        }
    }

}

