<?php

class Application_Model_ConfigMapper {

    protected $_db;

    public function __construct() {
        $this->_db = Zend_Db_Table::getDefaultAdapter();
    }

    public function getParam($param) {
        try {
            $select = $this->_db->select()
                    ->from("config", array("value"))
                    ->where("parameter = ?", $param);
            $result = $this->_db->fetchRow($select, array());
            if ($result) {
                return $result["value"];
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function pageName($module, $controller, $action) {
        try {
            $select = $this->_db->select()
                    ->from("paginas", array("descripcion"))
                    ->where("modulo = ?", $module)
                    ->where("controlador = ?", $controller)
                    ->where("accion = ?", $action);
            $stmt = $this->_db->fetchRow($select, array());
            if ($stmt) {
                return $stmt["descripcion"];
            }
            return "---";
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
