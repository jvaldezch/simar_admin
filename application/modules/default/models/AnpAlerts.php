<?php

class Default_Model_AnpAlerts {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Default_Model_DbTable_AnpAlerts();
    }

    public function obtener($gid) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->where("gid = ?", $gid);
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
