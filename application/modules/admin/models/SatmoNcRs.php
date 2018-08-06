<?php

class Admin_Model_SatmoNcRs {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_SatmoNcRs();
    }

    public function obtener($ridNc) {
        try {
            $sql = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from(array("r" => "ocean_color_satmo_nc_rs"), array('filename', 'path', 'min', 'max', 'projection', 'bit_depth', 'pix_res', 'mean', 'std_dev', 'no_data', 'x_min', 'y_min', 'x_max', 'y_max', 'format'))
                    ->joinLeft(array("n" => "ocean_color_satmo_nc"), 'n."rid" = r."ridNc"', array('year', 'day', 'composition', 'week', 'month', 'product', 'sensor', 'product_date', 'created', 'product_end', 'error'))
                    ->where('r."ridNc" = ?', $ridNc);
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerProducto($ridNc) {
        try {
            $sql = $this->_db_table->select()
                    ->setIntegrityCheck(false)
                    ->from(array("r" => "ocean_color_satmo_nc_rs"), array('filename', 'path', 'min', 'max', 'projection', 'bit_depth', 'pix_res', 'mean', 'std_dev', 'no_data', 'x_min', 'y_min', 'x_max', 'y_max', 'format'))
                    ->joinLeft(array("n" => "ocean_color_satmo_nc"), 'n."rid" = r."ridNc"', array('year', 'day', 'composition', 'week', 'month', 'product', 'sensor', 'product_date', 'created', 'product_end', 'error'))
                    ->where('r."ridNc" = ?', $ridNc)
                    ->where('r."format" = \'GTiff\'');
            $stmt = $this->_db_table->fetchRow($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}

