<?php

class Application_Model_Menus {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Application_Model_DbTable_Menus();
    }

    public function menus($rol) {
        try {
            $select = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from(array("p" => "menus"), array())
                    ->joinLeft(array("m" => "menus_principal"), "p.id = m.idMenu", array("id", "accion", "descripcion", "controlador"))
                    ->where("p.rol = ?", $rol)
                    ->where("activo = 1")
                    ->order("orden ASC");
            $stmt = $this->_db_table->fetchAll($select);
            if ($stmt) {
                $data = array();
                foreach ($stmt->toArray() as $item) {
                    $submenus = $this->submenus($item["id"]);
                    if (isset($submenus)) {
                        $item["submenu"] = $submenus;
                    }
                    $data[] = $item;
                }
                return $data;
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function submenus($idAccion) {
        try {
            $select = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from("menus_submenu", array("accion", "descripcion"))
                    ->where("idPrincipal = ?", $idAccion)
                    ->where("activo = 1");
            $stmt = $this->_db_table->fetchAll($select);
            if ($stmt) {
                return $stmt->toArray();
            }
            return false;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
