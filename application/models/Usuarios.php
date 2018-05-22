<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuarios
 *
 * @author Jaime
 */
class Application_Model_Usuarios {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Application_Model_DbTable_Usuarios();
    }

    /**
     * 
     * @param type $usuario
     * @return type
     * @throws Exception}
     */
    public function obtenerUsuario($usuario) {
        try {
            $sql = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from(array("u" => "usuarios"), array("id"))
                    ->joinInner(array("d" => "usuarios_datos"), "u.id = d.idUsuario", array("email", "nombre", "apellido"))
                    ->joinInner(array("r" => "roles"), "u.id = r.idUsuario", array("rol", "landing"))
                    ->where("u.username = ?", $usuario);
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }
    
    /**
     * 
     * @param int $idUsuario
     * @param string $password
     * @return type
     * @throws Exception}
     */
    public function challenge($idUsuario, $password) {
        try {
            $sql = $this->_db_table->select()                    
                    ->where("AES_DECRYPT(`password`, 'd43ff07dfc5830ef95642b6620db1c44fd20414d') = ?", $password)
                    ->where("id = ?", $idUsuario);
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return true;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
