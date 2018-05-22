<?php

class Administrador_Model_VucemBitacora {

    protected $_dbTable;

    public function __construct() {
        $this->_dbTable = new Administrador_Model_DbTable_VucemBitacora();
    }

    /**
     * 
     * @return array
     * @throws Exception
     */
    public function all() {
        try {
            $select = $this->_dbTable->select()
                    ->order("creado DESC");
            $stmt = $this->_dbTable->fetchAll($select);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

}
