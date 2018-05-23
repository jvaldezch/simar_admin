<?php

class Admin_Model_Categories {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_Categories();
    }

}
