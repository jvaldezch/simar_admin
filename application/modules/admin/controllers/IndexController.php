<?php

class Admin_IndexController extends Zend_Controller_Action {

    protected $_config;
    protected $_redirector;
    protected $_appconfig = null;
    protected $_session;

    public function init() {
        $this->_helper->layout->setLayout("admin/layout");
        $this->_appconfig = new Application_Model_ConfigMapper();
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV);
        $this->view->headMeta()->appendName("author", "");
        $this->view->headMeta()->appendName("description", "");
        $this->view->headLink()
                ->appendStylesheet("/bootstrap/css/bootstrap.min.css")
                ->appendStylesheet("/webfontkit/stylesheet.css")
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
        $this->view->title = $this->_appconfig->getParam("title") . " | Admin";
        $this->view->headLink()
                ->appendStylesheet("/datatables/jquery.dataTables.min.css");
//                ->appendStylesheet("/datatables/dataTables.bootstrap.min.css");
        $this->view->headScript()
                ->appendFile("/datatables/jquery.dataTables.min.js")
                ->appendFile("/datatables/jquery.dataTables.init.js");
//        $mapper = new Administrador_Model_VucemBitacora();
//        $arr = $mapper->all();
//        if (isset($arr) && !empty($arr)) {
//            $this->view->data = $arr;
//        }
    }

}
