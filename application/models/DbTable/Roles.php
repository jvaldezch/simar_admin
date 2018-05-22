<?php

class Application_Model_DbTable_Roles extends Zend_Db_Table {

    protected $_name = "roles";
    protected $_primary = "id";
    protected $_referenceMap = array(
        "Usuarios" => array(
            "columns" => "idUsuario",
            "refTableClass" => "Application_Model_DbTable_Usuarios",
            "refColumns" => "id"
        )
    );

}
