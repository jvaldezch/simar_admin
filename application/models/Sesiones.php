<?php

class Application_Model_Sesiones {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Application_Model_DbTable_Sesiones();
    }
    
    public function sesionNueva($usuario, $token) {
        try {
            $stmt = $this->_db_table->insert(array(
                "username" => $usuario,
                "token" => $token,
                "modified" => date("Y-m-d H:i:s"),
            ));
            if ($stmt) {
                return true;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function sesionVerificar($usuario) {
        try {
            $sql = $this->_db_table->select()
                    ->where("username = ?", $usuario);
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return (int) $stmt->id;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function sesionBorrar($id) {
        try {
            $stmt = $this->_db_table->delete(array("id = ?" => $id));
            if ($stmt) {
                return true;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }
    
    public function sesionActualizar($id) {
        try {
            $stmt = $this->_db_table->update(array("modified" => date("Y-m-d H:i:s")), array("id = ?" => $id));
            if ($stmt) {
                return true;
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function removeExpired() {
        try {
            $db = $this->_db_table->getAdapter();
            $stmt = $db->query("DELETE FROM sesiones WHERE (UNIX_TIMESTAMP() - modified) > lifetime;");
            $stmt->execute();
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    /**
     * 
     * @param int $id
     * @throws Exception
     */
    public function removeSessionId($id) {
        try {
            $this->_db_table->delete(array(
                "id = ?" => $id
            ));
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    /**
     * 
     * @param string $username
     * @return boolean
     * @throws Exception
     */
    public function verifyIfLogged($username) {
        try {
            $sql = $this->_db_table->select()
                    ->where("data LIKE ?", "%" . $username . "%");
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return true;
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    /**
     * 
     * @param int $id
     * @return boolean
     * @throws Exception
     */
    public function removeData($id) {
        try {
            $sql = $this->_db_table->select()
                    ->where("id = ?", $id);
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                $this->_db_table->update(array("data" => null), array(
                    "id = ?" => $id
                ));
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }
    
    /**
     * 
     * @param type $usuario
     * @param type $token
     * @return boolean
     * @throws Exception
     */
    public function verificarSesion($usuario, $token) {
        try {
            $sql = $this->_db_table->select()
                    ->where("username = ?", $usuario)
                    ->where("token = ?", $token);
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
