<?php

class Administrador_Model_DbTable_ClientesDireccion extends Zend_Db_Table_Abstract {

    protected $_name = "clientes_direccion";
    protected $_primary = "id";
    protected $_referenceMap = array(
        "Clientes" => array(
            "columns" => "idCliente",
            "refTableClass" => "Administrador_Model_DbTable_Clientes",
            "refColumns" => "id"
        )
    );

}
