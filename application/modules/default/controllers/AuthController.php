<?php

class Default_AuthController extends Zend_Controller_Action {

    protected $_config;
    protected $_firephp;
    protected $_auth;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        require_once 'FirePHPCore/lib/FirePHP.class.php';
        $this->_firephp = FirePHP::getInstance(true);
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
    }

    public function loginAction() {
        try {
            $r = $this->getRequest();
            if ($r->isPost()) {
                $mppr = new Application_Model_Sesiones();
                $form = new Application_Form_Login();
                if ($form->isValid($r->getPost())) {
                    $sessCookie = $this->getRequest()->getCookie('myVucemSession');
                    if (isset($sessCookie) && $sessCookie !== "") {
                        if ($mppr->verificarSesion($form->getValue("username"), $sessCookie) === true) {
                            $sesiones = new App_Sesiones(new Zend_Session_Namespace('AuthSessions'), new Application_Model_ConfigMapper());
                            $landing = $sesiones->iniciarSesion($form->getValue("username"));
                            if ($landing) {
                                $this->_firephp->warn($landing);
                                $this->_helper->json(array("success" => true, "landing" => $landing));
                            }
                        }
                        setcookie("myVucemSession", "", null, "/");
                    }
                    $sesiones = new App_Sesiones(new Zend_Session_Namespace('AuthSessions'), new Application_Model_ConfigMapper());
                    $landing = $sesiones->authenticate($form->getValue("username"), $form->getValue("password"));
                    if ($landing) {
                        $this->_helper->json(array("success" => true, "landing" => $landing));
                    }
                } else {
                    throw new Exception("Invalid input!");
                }
            } else {
                throw new Exception("Invalid request type!");
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

    public function logoutAction() {
        $sesiones = new App_Sesiones(new Zend_Session_Namespace('AuthSessions'), new Application_Model_ConfigMapper());
        $sesiones->salir();
        $this->_redirect('/');
    }

}
