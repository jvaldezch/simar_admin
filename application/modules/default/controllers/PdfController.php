<?php

class Default_PdfController extends Zend_Controller_Action {

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
    public function alertaAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "year" => array("Digits"),
                "week" => array("Digits"),
                "anp" => array("Digits"),
            );
            $v = array(
                "year" => array("NotEmpty", new Zend_Validate_Int()),
                "week" => array("NotEmpty", new Zend_Validate_Int()),
                "anp" => array("NotEmpty", new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("year") && $input->isValid("week") && $input->isValid("anp")) {

                $mppr = new Default_Model_SatmoNc();
                $arr = $mppr->obtener($input->year, $input->week, "satcoral", "sba");

                $mapper = new Default_Model_AnpAlerts();
                $row = $mapper->obtener($input->anp);

                if (!empty($arr) && !empty($row)) {

                    $basename = basename($arr["path"]);
                    $dirname = dirname($arr["path"]);

                    $pdf_filename = $dirname . DIRECTORY_SEPARATOR . substr($basename, 0, 30) . "_ANP" . $row["id"] . "_R-SBA-REPORT.pdf";

                    if (file_exists($pdf_filename)) {

                        header('Content-type: application/pdf');
                        header('Content-Disposition: inline; filename="' . basename($pdf_filename) . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Accept-Ranges: bytes');
                        @readfile($pdf_filename);

                    } else {
                        throw new Exception("File not found!");        
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
