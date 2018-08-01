<?php

class Usuario_Model_VirtualBuoys {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Usuario_Model_DbTable_VirtualBuoys();
    }

    public function obtener() {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order('name ASC');
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception('DB Exception found on ' . __METHOD__ . ': ' . $ex->getMessage());
        }
    }

}

