<?php

class Admin_Model_ResEspecialistas {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_ResEspecialistas();
    }

    public function obtener($search = null) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order("nombre ASC");
            if (isset($search) && $search !== '') {
                $sql->where('nombre ILIKE ?', '%' . $search . '%')
                    ->orWhere('apellido_paterno ILIKE ?', '%' . $search . '%')
                    ->orWhere('apellido_materno ILIKE ?', '%' . $search . '%');
            }
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
