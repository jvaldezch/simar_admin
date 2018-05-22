<?php

class Administrador_Model_Clientes {

    protected $_dbTable;

    public function __construct() {
        $this->_dbTable = new Administrador_Model_DbTable_Clientes();
    }

    public function all() {
        try {
            $sql = $this->_dbTable->select()
                    ->from(array("c" => "clientes"), array("*", new Zend_Db_Expr("(SELECT creado FROM sellos s WHERE s.idCliente = c.id ORDER BY creado DESC LIMIT 1) as sello")));
            $stmt = $this->_dbTable->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
