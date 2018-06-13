<?php

class Default_AuthController extends Zend_Controller_Action {

    protected $_config;
    protected $_auth;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
    }

    public function loginAction() {
        try {
            $r = $this->getRequest();
            if ($r->isPost()) {
                $f = array(
                    "*" => array("StringTrim"),
                );
                $v = array(
                    "username" => array("NotEmpty"),
                    "password" => array("NotEmpty"),
                );
                $input = new Zend_Filter_Input($f, $v, $r->getPost());
                if ($input->isValid("username") && $input->isValid("password")) {
                    $auth = new Auth_Sessions(array("username" => $input->username, "password" => $input->password));
                    $challenge = $auth->autorizar();
                    $this->_helper->json($challenge);
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
        try {
            $auth = new Auth_Sessions();
            if ($auth->cerrarSesion()) {
                $this->_helper->json(array("success" => true));
            }
        } catch (Exception $ex) {
            $this->_helper->json(array("success" => false, "message" => $ex->getMessage()));
        }
    }

}
