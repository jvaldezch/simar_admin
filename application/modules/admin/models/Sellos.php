<?php

class Administrador_Model_Sellos {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Administrador_Model_DbTable_Sellos();
    }

    /**
     * 
     * @param type $idAgente
     * @param type $data
     * @param type $rfc
     * @param type $encriptacion
     * @return boolean
     * @throws Exception
     */
    public function cargarSelloAgente($idAgente, $data, $rfc, $encriptacion = null) {
        try {
            $key = sha1($rfc);
            $row = array(
                'idAgente' => $idAgente,
                'certificado' => new Zend_Db_Expr("AES_ENCRYPT('{$data["certificado"]}', '{$key}')"),
                'llave' => new Zend_Db_Expr("AES_ENCRYPT('{$data["llave"]}', '{$key}')"),
                'secure' => new Zend_Db_Expr("AES_ENCRYPT('{$data["secure"]}', '{$key}')"),
                'password' => new Zend_Db_Expr("AES_ENCRYPT('{$data["password"]}', '{$key}')"),
                'webservice' => new Zend_Db_Expr("AES_ENCRYPT('{$data["webservice"]}', '{$key}')"),
                'encriptacion' => $encriptacion,
                'archivoCer' => $data["archivoCer"],
                'archivoKey' => $data["archivoKey"],
                'creado' => date('Y-m-d H:i:s'),
            );
            $stmt = $this->_db_table->insert($row);
            if ($stmt) {
                return true;
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    /**
     * 
     * @param type $idCliente
     * @param type $data
     * @param type $rfc
     * @param type $encriptacion
     * @return boolean
     * @throws Exception
     */
    public function cargarSelloCliente($idCliente, $data, $rfc, $encriptacion = null) {
        try {
            $key = sha1($rfc);
            $row = array(
                'idCliente' => $idCliente,
                'certificado' => new Zend_Db_Expr("AES_ENCRYPT('{$data["certificado"]}', '{$key}')"),
                'llave' => new Zend_Db_Expr("AES_ENCRYPT('{$data["llave"]}', '{$key}')"),
                'secure' => new Zend_Db_Expr("AES_ENCRYPT('{$data["secure"]}', '{$key}')"),
                'password' => new Zend_Db_Expr("AES_ENCRYPT('{$data["password"]}', '{$key}')"),
                'webservice' => new Zend_Db_Expr("AES_ENCRYPT('{$data["webservice"]}', '{$key}')"),
                'encriptacion' => $encriptacion,
                'archivoCer' => $data["archivoCer"],
                'archivoKey' => $data["archivoKey"],
                'creado' => date('Y-m-d H:i:s'),
            );
            $stmt = $this->_db_table->insert($row);
            if ($stmt) {
                return true;
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    /**
     * 
     * @param type $idAgente
     * @return boolean
     * @throws Exception
     */
    public function obtenerSellosAgente($idAgente) {
        try {
            $select = $this->_db_table->select()
                    ->from($this->_db_table, array("archivoKey", "archivoCer", "creado"))
                    ->where("idAgente = ?", $idAgente);
            $stmt = $this->_db_table->fetchAll($select);
            if ($stmt) {
                return $stmt->toArray();
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    /**
     * 
     * @param type $idCliente
     * @return boolean
     * @throws Exception
     */
    public function obtenerSellosCliente($idCliente) {
        try {
            $select = $this->_db_table->select()
                    ->from($this->_db_table, array("id","archivoKey", "archivoCer", "creado", "default"))
                    ->where("idCliente = ?", $idCliente);
            $stmt = $this->_db_table->fetchAll($select);
            if ($stmt) {
                return $stmt->toArray();
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    /**
     * 
     * @return boolean
     * @throws Exception
     */
    public function obtenerSellos() {
        try {
            $rfc = new Zend_Db_Expr("CASE WHEN s.idCliente IS NULL THEN (SELECT a.rfc FROM agentes a WHERE a.id = s.idAgente) ELSE (SELECT c.identificador FROM clientes c WHERE c.id = s.idCliente) END as rfc");
            $select = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from(array('s' => 'sellos'), array("id", $rfc, "archivoKey", "archivoCer", "creado", "modificado"));
            $stmt = $this->_db_table->fetchAll($select);
            if ($stmt) {
                return $stmt->toArray();
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    /**
     * 
     * @return boolean
     * @throws Exception
     */
    public function obtenerSello($id) {
        try {
            $rfc = new Zend_Db_Expr("CASE WHEN s.idCliente IS NULL THEN (SELECT a.rfc FROM agentes a WHERE a.id = s.idAgente) ELSE (SELECT c.identificador FROM clientes c WHERE c.id = s.idCliente) END as identificador");
            $select = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from(array('s' => 'sellos'), array("idCliente",$rfc, "encriptacion"))
                    ->where("id = ?", $id);
            $stmt = $this->_db_table->fetchRow($select);
            if ($stmt) {
                $row = $stmt->toArray();
                return $data = array(
                    'idCliente' => $row["idCliente"],
                    'identificador' => $row["identificador"],
                    'encriptacion' => $row["encriptacion"],
                    'pass' => $this->_desencriptarCampo($id, sha1($row["identificador"]), "password"),
                    'ws' => $this->_desencriptarCampo($id, sha1($row["identificador"]), "webservice"),
                    'cer' => $this->_desencriptarCampo($id, sha1($row["identificador"]), "certificado"),
                    'secure' => $this->_desencriptarCampo($id, sha1($row["identificador"]), "secure"),
                );
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

    protected function _desencriptarCampo($idSello, $key, $field) {
        try {
            $select = $this->_db_table->select()
                    ->from($this->_db_table, array(new Zend_Db_Expr("AES_DECRYPT(`{$field}`, '{$key}') as `{$field}`")))
                    ->where("id = ?", $idSello);
            $stmt = $this->_db_table->fetchRow($select);
            if ($stmt) {
                $row = $stmt->toArray();
                return $row[$field];
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("Zend DB Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Exception found on " . __METHOD__ . " > " . $ex->getMessage());
        }
    }

}
