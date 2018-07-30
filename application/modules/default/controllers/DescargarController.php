<?php

class Default_DescargarController extends Zend_Controller_Action {

    protected $_config;
    protected $_redirector;
    protected $_appConfig = null;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
    }
    
    public function preDispatch() {
    }
    
    public function postDispatch() {

    }

    /**
     * /default/pdf/alerta?anp=1&year=2018&week=1
     * 
     */
    public function indexAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "rid" => array("Digits"),
                "product" => array("StringToLower"),
            );
            $v = array(
                "rid" => array("NotEmpty", new Zend_Validate_Int()),
                "product" => array("NotEmpty"),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("rid") && $input->isValid("product")) {

                $mppr = new Default_Model_SatmoNcRs();
                $arr = $mppr->obtenerProducto($input->rid);
                if (!empty($arr)) {
                    $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $arr['path']);
                    if ($input->product == 'gtiff') {
                        if (file_exists($arr['path'])) {
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: inline; filename="' . basename($arr['path']) . '"');
                            header('Content-Transfer-Encoding: binary');
                            header('Accept-Ranges: bytes');
                            @readfile($arr['path']);
                        } else {
                            throw new Exception("No file found!");
                        }
                    } else if ($input->product == 'png') {
                        $png_filename = $filename . '.png';
                        if (file_exists($png_filename)) {
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: inline; filename="' . basename($png_filename) . '"');
                            header('Content-Transfer-Encoding: binary');
                            header('Accept-Ranges: bytes');
                            @readfile($png_filename);
                        } else {
                            throw new Exception("No file found!");
                        }                        
                    } else if ($input->product == 'kmz') {
                        $kmz_filename = $filename . '.kmz';
                        if (file_exists($kmz_filename)) {
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: inline; filename="' . basename($kmz_filename) . '"');
                            header('Content-Transfer-Encoding: binary');
                            header('Accept-Ranges: bytes');
                            @readfile($kmz_filename);
                        } else {
                            throw new Exception("No file found!");
                        }
                    } else {
                        throw new Exception("Invalid format type!");
                    }
                } else {
                    throw new Exception("No data found!");
                }
            }  else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

}
