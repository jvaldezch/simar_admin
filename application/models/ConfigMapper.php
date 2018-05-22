<?php

class Application_Model_ConfigMapper {

    protected $_db;

    public function __construct() {
        $this->_db = Zend_Db_Table::getDefaultAdapter();
    }

    public function getParam($param) {
        try {
            $sql = $this->_db->select()
                    ->from("config", array("value"))
                    ->where("param = ?", $param);
            $stmt = $this->_db->fetchRow($sql, array());
            if ($stmt) {
                return $stmt["value"];
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
