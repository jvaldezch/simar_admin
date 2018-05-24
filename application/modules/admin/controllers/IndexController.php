<?php

class Admin_IndexController extends Zend_Controller_Action {

    protected $_config;
    protected $_redirector;
    protected $_appConfig = null;
    protected $_session;

    public function init() {
        $this->_helper->layout->setLayout("admin/layout");
        $this->_appConfig = new Application_Model_ConfigMapper();
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV);
        $this->view->headMeta()->appendName("author", "");
        $this->view->headMeta()->appendName("description", "");
        $this->view->headLink()
                ->appendStylesheet("/bootstrap/css/bootstrap.min.css")
                ->appendStylesheet("/css/styles.css");
        $this->view->headScript()
                ->appendFile("/js/jquery-1.11.1.min.js")
                ->appendFile("/bootstrap/js/bootstrap.min.js");
    }

    public function preDispatch() {
        
    }
    
    public function postDispatch() {

    }

    public function indexAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headLink()
                ->appendStylesheet("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css")
                ->appendStylesheet("/js/common/contentxmenu/jquery.contextMenu.min.css");;
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js")
                ->appendFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/locales/bootstrap-datepicker.es.min.js")
                ->appendFile("/js/common/contentxmenu/jquery.contextMenu.min.js")
                ->appendFile("/js/admin/index.js");
    }

    public function verProductoAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/admin/ver-producto.js");
    }

    public function categoriasAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js");
    }

    public function poligonalesAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js");
    }

    public function bitacoraAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js");   
    }

    public function verMapaAction() {
        $this->_helper->layout()->disableLayout();
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "rid" => array("Digits"),
        );
        $v = array(
                "rid" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("rid")) {
                $mppr = new Admin_Model_SatmoNcRs();
                $arr = $mppr->obtenerProducto($input->rid);
                if (isset($arr)) {
                        $composition = $arr["composition"] = 'day' ? 'nsst' : $arr["compostion"];
                        $url = "http://35.196.161.155:8085/tiles/satmo/" . $arr["sensor"] . "/" . $composition . "/" . date("Y-m-d", strtotime($arr["product_date"])) . "/wmts/nsst/webmercator/{z}/{x}/{y}.png";
                        //var_dump($url);
                        $this->view->url = $url;
                        $this->view->layerName = strtoupper($arr["sensor"]) . " " . date("Y-m-d", strtotime($arr["product_date"]));
                        $this->view->xMin = $arr["x_min"];
                        $this->view->yMin = $arr["y_min"];
                        $this->view->xMax = $arr["x_max"];
                        $this->view->yMax = $arr["y_max"];
                        $this->view->filename = $arr["filename"];
                }
        }
    }

}
