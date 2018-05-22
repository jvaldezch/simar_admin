<?php

class Administrador_Model_Agentes {

    protected $_dbTable;

    public function __construct() {
        $this->_dbTable = new Administrador_Model_DbTable_Agentes();
    }

    public function all() {
        try {
            $sql = $this->_dbTable->select()
                    ->from($this->_dbTable, array("*"));
            $stmt = $this->_dbTable->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function asignados($idCliente) {
        try {
            $mapper = new Administrador_Model_ClientesSelloAgente();
            $sql = $this->_dbTable->select()
                    ->from($this->_dbTable, array("*"));
            $stmt = $this->_dbTable->fetchAll($sql);
            if ($stmt) {
                $arr = array();
                foreach ($stmt->toArray() as $item) {
                    $item["asignado"] = $mapper->search($idCliente, $item["id"]);
                    $arr[] = $item;
                }
                return $arr;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
