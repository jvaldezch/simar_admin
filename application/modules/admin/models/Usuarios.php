<?php

class Administrador_Model_Usuarios {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Administrador_Model_DbTable_Usuarios();
    }

    public function find(Administrador_Model_Table_Usuarios $table) {
        try {
            $result = $this->_db_table->fetchRow(
                    $this->_db_table->select()
                            ->where('id = ?', $table->getId())
            );
            if (0 == count($result)) {
                return;
            }
            $table->setId($result->id);
            $table->setUsername($result->username);
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
