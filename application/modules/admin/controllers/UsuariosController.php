<?php

class Admin_UsuariosController extends Zend_Controller_Action {

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
        $this->view->title = $this->_appConfig->getParam("title") . " | Usuarios registrados (SIMAR)";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/usuarios/index.js?" . time());
    }

    public function administradorAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Usuarios";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/usuarios/administrador.js?" . time());
    }

    public function verUsuarioAdministradorAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Usuario";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/usuarios/ver-usuario-administrador.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array("NotEmpty"),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
                $mppr = new Admin_Model_UsersAdmin();
                $arr = $mppr->obtenerUsuario($input->id);
                $this->view->arr = $arr;

                $mppr = new Admin_Model_UsersRoles();
                $arr = $mppr->obtener();
                if (!empty($arr)) {
                        $this->view->roles = $arr;
                }
        }
    }

    public function verUsuarioAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Usuario registrado";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/usuarios/ver-usuario.js?" . time());
        $f = array(
                "*" => array("StringTrim", "StripTags"),
                "id" => array("Digits"),
        );
        $v = array(
                "id" => array(new Zend_Validate_Int()),
        );
        $input = new Zend_Filter_Input($f, $v, $this->_request->getParams());
        if ($input->isValid("id")) {
        }
    }

    public function altaUsuarioAdministradorAction() {
        $this->view->title = $this->_appConfig->getParam("title") . " | Alta de usuario";
        $this->view->headScript()
                ->appendFile("/js/common/loadingoverlay.min.js")
                ->appendFile("/js/admin/usuarios/alta-usuario-administrador.js?" . time());
        $mppr = new Admin_Model_UsersRoles();
        $arr = $mppr->obtener();
        if (!empty($arr)) {
                $this->view->roles = $arr;
        }
    }

}
