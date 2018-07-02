<?php

class Admin_Model_SatmoNc {

    protected $_db_table;

    public function __construct() {
        $this->_db_table = new Admin_Model_DbTable_SatmoNc();
    }

    public function obtener($year = null, $type = null) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->order("product_date DESC");
            if (isset($year)) {
                $sql->where('year = ?', $year);
            }
            if (isset($type)) {
                $sql->where('composition = ?', $type);
            }
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function buscar($search) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array('*'))
                    ->where("filename LIKE ?", "%" . $search . "%")
                    ->order("product_date DESC");
            return $sql;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerAnios() {
        try {
            $sql = $this->_db_table->select()
                    ->distinct()
                    ->from($this->_db_table, array('year'))
                    ->where('year IS NOT NULL')
                    ->order('year DESC')
                    ->group('year');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerNsst($year, $month) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array("rid", new Zend_Db_Expr("to_char(product_date, 'DD_MM_YYYY') as product_id"), "path", new Zend_Db_Expr("replace(replace(\"path\", '/mnt/arrakis/data/opendap', 'https://simar.conabio.gob.mx:8443/satmo'), filename, '') AS \"url\"")))
                    ->where("EXTRACT (YEAR FROM product_date)::int = ?", $year)
                    ->where("EXTRACT (MONTH FROM product_date)::int = ?", $month)
                    ->where("composition = 'day'")
                    ->order('product_date ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerWnsst($year, $month) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array("rid", new Zend_Db_Expr("to_char(product_date, 'DD_MM_YYYY') as product_id"), "path", new Zend_Db_Expr("replace(replace(\"path\", '/mnt/arrakis/data/opendap', 'https://simar.conabio.gob.mx:8443/satmo'), filename, '') AS \"url\"")))
                    ->where("EXTRACT (YEAR FROM product_date)::int = ?", $year)
                    ->where("EXTRACT (MONTH FROM product_date)::int = ?", $month)
                    ->where("composition = 'w-nsst'")
                    ->order('product_date ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerWynsst($year, $month) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array("rid", new Zend_Db_Expr("to_char(product_date, 'DD_MM_YYYY') as product_id"), "path", new Zend_Db_Expr("replace(replace(\"path\", '/mnt/arrakis/data/opendap', 'https://simar.conabio.gob.mx:8443/satmo'), filename, '') AS \"url\"")))
                    ->where("EXTRACT (YEAR FROM product_date)::int = ?", $year)
                    ->where("EXTRACT (MONTH FROM product_date)::int = ?", $month)
                    ->where("composition = 'wy-nsst'")
                    ->order('product_date ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerMnsst($year, $month) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array("rid", new Zend_Db_Expr("to_char(product_date, 'DD_MM_YYYY') as product_id"), "path", new Zend_Db_Expr("replace(replace(\"path\", '/mnt/arrakis/data/opendap', 'https://simar.conabio.gob.mx:8443/satmo'), filename, '') AS \"url\"")))
                    ->where("EXTRACT (YEAR FROM product_date)::int = ?", $year)
                    ->where("EXTRACT (MONTH FROM product_date)::int = ?", $month)
                    ->where("composition = 'm-nsst'")
                    ->order('product_date ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerWhs($year, $month) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array("rid", new Zend_Db_Expr("to_char(product_date, 'DD_MM_YYYY') as product_id"), "path", new Zend_Db_Expr("replace(replace(\"path\", '/mnt/arrakis/data/opendap', 'https://simar.conabio.gob.mx:8443/satmo'), filename, '') AS \"url\"")))
                    ->where("EXTRACT (YEAR FROM product_date)::int = ?", $year)
                    ->where("EXTRACT (MONTH FROM product_date)::int = ?", $month)
                    ->where("composition = 'whs'")
                    ->order('product_date ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerDhw($year, $month) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array("rid", new Zend_Db_Expr("to_char(product_date, 'DD_MM_YYYY') as product_id"), "path", new Zend_Db_Expr("replace(replace(\"path\", '/mnt/arrakis/data/opendap', 'https://simar.conabio.gob.mx:8443/satmo'), filename, '') AS \"url\"")))
                    ->where("EXTRACT (YEAR FROM product_date)::int = ?", $year)
                    ->where("EXTRACT (MONTH FROM product_date)::int = ?", $month)
                    ->where("composition = 'dhw'")
                    ->order('product_date ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

    public function obtenerSba($year, $month) {
        try {
            $sql = $this->_db_table->select()
                    ->from($this->_db_table, array("rid", new Zend_Db_Expr("to_char(product_date, 'DD_MM_YYYY') as product_id"), "path", new Zend_Db_Expr("replace(replace(\"path\", '/mnt/arrakis/data/opendap', 'https://simar.conabio.gob.mx:8443/satmo'), filename, '') AS \"url\"")))
                    ->where("EXTRACT (YEAR FROM product_date)::int = ?", $year)
                    ->where("EXTRACT (MONTH FROM product_date)::int = ?", $month)
                    ->where("composition = 'sba'")
                    ->order('product_date ASC');
            $stmt = $this->_db_table->fetchAll($sql);
            if ($stmt) {
                return $stmt->toArray();
            }
            return;
        } catch (Zend_Db_Exception $ex) {
            throw new Exception("DB Exception found on " . __METHOD__ . ": " . $ex->getMessage());
        }
    }

}
