<?php

class Application_Model_DbTable_UsuariosDatos extends Zend_Db_Table {

    protected $_name = "usuarios_datos";
    protected $_primary = "id";
    protected $_referenceMap = array(
        "Usuarios" => array(
            "columns" => "idUsuario",
            "refTableClass" => "Application_Model_DbTable_Usuarios",
            "refColumns" => "id"
        )
    );

}
