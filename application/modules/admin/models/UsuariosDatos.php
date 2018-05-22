<?php

class Administrador_Model_UsuariosDatos {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Administrador_Model_DbTable_UsuariosDatos();
    }

    public function find(Administrador_Model_Table_UsuariosDatos $table) {
        try {
            $result = $this->_db_table->fetchRow(
                    $this->_db_table->select()
                            ->where('idUsuario = ?', $table->getIdUsuario())
            );
            if (0 == count($result)) {
                return;
            }
            $table->setId($result->id);
            $table->setIdUsuario($result->idUsuario);
            $table->setNombre($result->nombre);
            $table->setApellido($result->apellido);
            $table->setEmail($result->email);
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }
    
}
