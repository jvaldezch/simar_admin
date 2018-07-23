<?php

class Default_Model_SatmoNc {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Default_Model_DbTable_SatmoNc();
    }

    public function obtener($year, $week, $sensor = null, $type = null) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->where('year = ?', $year)
                    ->where('week = ?', $week);
            if (isset($sensor)) {
                $sql->where('sensor = ?', $sensor);
            }
            if (isset($type)) {
                $sql->where('composition = ?', $type);
            }
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
