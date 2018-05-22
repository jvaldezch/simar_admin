<?php

class Administrador_Model_AduanasAgente {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Administrador_Model_DbTable_AduanasAgente();
    }

    public function obtenerAduanas($idAgente) {
        try {
            $sql = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from(array('a' => 'aduanas_agente'), array('*'))
                    ->joinLeft(array('n' => 'aduanas'), "a.idAduana = n.id", array('nombre', 'aduana', 'seccion'))
                    ->where('a.idAgente = ?', $idAgente)
                    ->order("aduana ASC");
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function verificar($idAgente, $idAduana) {
        try {
            $sql = $this->_db_table->select()
                    ->from(array('aduanas_agente'), array('*'))
                    ->where('idAgente = ?', $idAgente)
                    ->where('idAduana = ?', $idAduana);
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return true;
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function agregar($idAgente, $idAduana) {
        try {
            $stmt = $this->_db_table->insert(array(
                'idAgente' => $idAgente,
                'idAduana' => $idAduana
            ));
            if ($stmt) {
                return true;
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
