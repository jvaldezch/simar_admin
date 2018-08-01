<?php

class Admin_BoyasController extends Zend_Controller_Action {

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
                ->appendStylesheet("/css/styles.css?" . time());
        $this->view->headScript()
                ->appendFile("/js/jquery-1.11.1.min.js")
                ->appendFile("/bootstrap/js/bootstrap.min.js")
                ->appendFile("/js/common/common.js?" . time());
    }

    public function preDispatch() {
        $auth = new Auth_Sessions();
        if ($auth->isAuthenticated()) {
                if ($auth->getRole() == 'admin') {
                        $this->view->profile = $auth->getProfile();
                        $this->view->username = $auth->getUsername();
                        $auth->actualizar();
                } else {
                        throw new Exception('Access restricted');
                }
        } else {
                $this->getResponse()->setRedirect('/');
        }
        $mppr = new Admin_Model_Categories();
        $arr = $mppr->obtenerMenuCategorias();
        if (!empty($arr)) {
                $this->view->categorias = $arr;
        }
        $arr = $mppr->obtenerMenuGrupos();
        if (!empty($arr)) {
                $this->view->grupos = $arr;
        }
        $mppr = new Admin_Model_CaProducts();
        $arr = $mppr->obtenerMenuProductos();
        if (!empty($arr)) {
                $this->view->productos = $arr;
        }
    }
    
    public function postDispatch() {

    }

    public function indexAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Boyas virtuales";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/boyas/index.js?" . time());
    }

    public function verBoyaAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Boya";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/boyas/ver-boya.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
        );
        $v = array(
                "id" => array("NotEmpty"),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
        }
    }

}
