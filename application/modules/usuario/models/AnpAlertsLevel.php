<?php

class Usuario_Model_AnpAlertsLevel {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Usuario_Model_DbTable_AnpAlertsLevel();
    }

    public function datosPoligonal($id) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->where("gid_anp = ?", $id)
                    ->order("year DESC")
                    ->order("week DESC");
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
