<?php

class Admin_GetController extends Zend_Controller_Action {

    protected $_appConfig = null;
    protected $_session;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_appConfig = new Application_Model_ConfigMapper();
    }

    public function preDispatch() {
        parent::preDispatch();
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new Zend_Controller_Request_Exception("Not an AJAX request detected");
        }
    }

    public function productosAction() {
        try {
            $view = new Zend_View();
            $view->setScriptPath(realpath(dirname(__FILE__)) . "/../views/scripts/get/");
            $view->setHelperPath(realpath(dirname(__FILE__)) . "/../views/helpers/");

            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "page" => array("Digits"),
                "size" => array("Digits"),
                "year" => array("Digits"),
                "type" => array("StringToLower"),
            );
            $v = array(
                "page" => array(new Zend_Validate_Int(), "default" => 1),
                "size" => array(new Zend_Validate_Int(), "default" => 20),
                "year" => array(new Zend_Validate_Int()),
                "type" => array("NotEmpty"),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());

            $mppr = new Admin_Model_SatmoNc();
            $arr = $mppr->obtener($input->year, $input->type);

            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($arr));
            $paginator->setItemCountPerPage($input->size);
            $paginator->setCurrentPageNumber($input->page);
            $view->paginator = $paginator;

            $view->dataDir = $this->_appConfig->getParam("opendap_dir");
            $view->satmoDir = $this->_appConfig->getParam("satmo_url");

            $paginatorControl = $view->paginationControl($paginator);

            $this->_helper->json(array("success" => true, "results" => $view->render("productos.phtml"), "paginator" => $paginatorControl, "info" => $paginator->getPages()));
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerProductoAction() {
        try {
            $f = array(
                "*" => array("StringTrim", "StripTags"),
                "rid" => array("Digits"),
            );
            $v = array(
                "rid" => array(new Zend_Validate_Int()),
            );
            $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
            if ($input->isValid("rid")) {

                $dataDir = $this->_appConfig->getParam("opendap_dir");
                $satmoDir = $this->_appConfig->getParam("satmo_url"); 

                $mppr = new Admin_Model_SatmoNcRs();
                $row = $mppr->obtener($input->rid);
                $arr = array();
                if (!empty($row)) {
                    foreach($row as $v) {
                        if ($v["format"] == 'GTiff') {
                            $arr["download"] = str_replace($dataDir, $satmoDir, $v["path"]);
                            $arr["filename"] = $v["filename"];
                            $arr["year"] = $v["year"];
                            $arr["day"] = $v["day"];
                            $arr["composition"] = $v["composition"];
                            $arr["week"] = $v["week"];
                            $arr["month"] = $v["month"];
                            $arr["product"] = $v["product"];
                            $arr["sensor"] = $v["sensor"];
                            $arr["min"] = $v["min"];
                            $arr["max"] = $v["max"];
                            $arr["mean"] = $v["mean"];
                            $arr["projection"] = $v["projection"];
                            $arr["bit_depth"] = $v["bit_depth"];
                            $arr["pix_res"] = $v["pix_res"];
                            $arr["std_dev"] = $v["std_dev"];
                            $arr["no_data"] = $v["no_data"];
                            $arr["x_min"] = $v["x_min"];
                            $arr["y_min"] = $v["y_min"];
                            $arr["x_max"] = $v["x_max"];
                            $arr["y_max"] = $v["y_max"];
                        }
                        if ($v["format"] == 'mapserver') {
                            $arr["url"] = $v["path"];
                        }
                    }
                }
                $this->_helper->json(array("success" => true, "results" => $arr));
            } else {
                throw new Exception("Invalid input!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function obtenerAniosAction() {
        try {
            $mppr = new Admin_Model_SatmoNc();
            $arr = $mppr->obtenerAnios();
            if (!empty($arr)) {
                $this->_helper->json(array("success" => true, "results" => $arr));
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

}
