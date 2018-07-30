<?php

class Usuario_Model_ResInstituciones {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Usuario_Model_DbTable_ResInstituciones();
    }

    public function obtener($search = null) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order("nombre ASC");
            if (isset($search) && trim($search) !== '') {
                $sql->where('nombre ILIKE ?', '%' . $search . '%');
            }
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function institucion($rid) {
        try {
            $sql = $this->_db_table->select()
                    ->from(array('i' => 'res_instituciones'), array('*'))
                    ->where('i.rid = ?', $rid);
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
