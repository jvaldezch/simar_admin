<?php

class Admin_Model_SatmoNc {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_SatmoNc();
    }

    public function obtener($year = null, $type = null) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order("product_date DESC");
            if (isset($year)) {
                $sql->where('year = ?', $year);
            }
            if (isset($type)) {
                $sql->where('composition = ?', $type);
            }
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function buscar($search) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->where("filename LIKE ?", "%" . $search . "%")
                    ->order("product_date DESC");
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerAnios() {
        try {
            $sql = $this->_db_table->select()
                    ->distinct()
                    ->from($this->_db_table, array('year'))
                    ->where('year IS NOT NULL')
                    ->order('year DESC')
                    ->group('year');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
