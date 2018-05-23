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
                ->appendStylesheet("/datatables/jquery.dataTables.min.css")
                ->appendStylesheet("/datatables/dataTables.bootstrap.min.css");
        $this->view->headScript()
                ->appendFile("/datatables/jquery.dataTables.min.js")
                ->appendFile("/datatables/jquery.dataTables.init.js")
                ->appendFile("/js/common/loadingoverlay.min.js")
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
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/admin/ver-producto.js");
        
    }

    public function poligonalesAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/admin/ver-producto.js");
        
    }

    public function bitacoraAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Admin";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/common/common.js")
                ->appendFile("/js/admin/ver-producto.js");
        
    }

}
