<?php

class Admin_Model_UsersAdmin {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_UsersAdmin();
    }

    public function obtener($search = null) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order('name ASC');
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception('DB Exception found on ' . __METHOD__ . ': ' . $ex->getMessage());
        }
    }

    public function obtenerUsuario($id) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->where('id = ?', $id);
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception('DB Exception found on ' . __METHOD__ . ': ' . $ex->getMessage());
        }
    }

}

