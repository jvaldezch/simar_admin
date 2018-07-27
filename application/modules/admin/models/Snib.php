<?php

class Admin_Model_Snib {

    protected $_db;

    public function __construct() {
        $this->_db = Zend_Registry::get('snib');
    }

    public function obtener($search = null) {
        try {
            $sql = $this->_db->select()
                    ->from("informaciongeoportal", array('*'));
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerEspecimen($id) {
        try {
            $sql = $this->_db->select()
                    ->from("informaciongeoportal", array('*'))
                    ->where('idejemplar = ?', $id);
            $stmt = $this->_db->fetchRow($sql);
            if ($stmt) {
                return $stmt;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
