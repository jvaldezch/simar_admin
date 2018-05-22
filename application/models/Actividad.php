<?php

class Application_Model_Actividad {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Application_Model_DbTable_Actividad();
    }

}
