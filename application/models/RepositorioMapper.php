<?php

class Application_Model_RepositorioMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway provided");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable("Application_Model_DbTable_Repositorio");
        }
        return $this->_dbTable;
    }

    public function obtener(Application_Model_Table_Repositorio $table) {
        try {
            $result = $this->getDbTable()->fetchRow(
                    $this->getDbTable()->select()
                            ->where("id = ?", $table->getId())
                            ->where("idCliente = ?", $table->getIdCliente())
            );
            if (0 == count($result)) {
                return;
            }
            $table->setId($result->id);
            $table->setIdCliente($result->idCliente);
            $table->setDirectorio($result->directorio);
            $table->setArchivo($result->archivo);
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function buscar(Application_Model_Table_Repositorio $table) {
        try {
            $result = $this->getDbTable()->fetchRow(
                    $this->getDbTable()->select()
                            ->where("idCliente = ?", $table->getIdCliente())
                            ->where("archivo = ?", $table->getArchivo())
            );
            if (0 == count($result)) {
                return;
            }
            $table->setId($result->id);
            $table->setIdCliente($result->idCliente);
            $table->setDirectorio($result->directorio);
            $table->setArchivo($result->archivo);
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function save(Application_Model_Table_Repositorio $table) {
        try {
            $data = array(
                "idCliente" => $table->getIdCliente(),
                "directorio" => $table->getDirectorio(),
                "archivo" => $table->getArchivo(),
                "creado" => date("Y-m-d H:i:s"),
            );
            if (null === ($id = $table->getId())) {
                unset($data["id"]);
                $id = $this->getDbTable()->insert($data);
                $table->setId($id);
            } else {
                $this->getDbTable()->update($data, array("id = ?" => $id));
            }
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function fetchAll($idCliente) {
        try {
            $result = $this->getDbTable()->fetchAll(
                    $this->getDbTable()->select()
                            ->where("idCliente = ?", $idCliente)
            );
            if ($result) {
                return $result->toArray();
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
