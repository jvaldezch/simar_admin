<?php

class Administrador_Model_ClientesSelloAgente {

    protected $_dbTable;

    public function __construct() {
        $this->_dbTable = new Administrador_Model_DbTable_ClientesSelloAgente();
    }

    public function find(Administrador_Model_Table_ClientesSelloAgente $table) {
        try {
            $stmt = $this->_dbTable->fetchRow(
                    $this->_dbTable->select()
                            ->where("idCliente = ?", $table->getIdCliente())
                            ->where("idSelloAgente = ?", $table->getIdSelloAgente()
            ));
            if ($stmt) {
                $table->setId($stmt->id);
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    public function search($idCliente, $idSelloAgente) {
        try {
            $select = $this->_dbTable->select()
                    ->where("idCliente = ?", $idCliente)
                    ->where("idSelloAgente = ?", $idSelloAgente);
            $stmt = $this->_dbTable->fetchRow($select);
            if ($stmt) {
                return true;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    public function save(Administrador_Model_Table_ClientesSelloAgente $table) {
        try {
            $data = array(
                "idCliente" => $table->getIdCliente(),
                "idSelloAgente" => $table->getIdSelloAgente(),
            );
            if (null === ($id = $table->getId())) {
                unset($data["id"]);
                $id = $this->_dbTable->insert($data);
                $table->setId($id);
            } else {
                $this->_dbTable->update($data, array("id = ?" => $id));
            }
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    public function delete(Administrador_Model_Table_ClientesSelloAgente $table) {
        try {
            $this->_dbTable->delete(array("id = ?" => $table->getId()));
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

}
