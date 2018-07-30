<?php

class Usuario_PostController extends Zend_Controller_Action {

    protected $_appconfig = null;
    protected $_session;
    protected $_postData;

    public function init() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function preDispatch() {
        $auth = new Auth_Sessions();
        if ($auth->isAuthenticated()) {
            if ($auth->getRole() == 'user') {
                $auth->actualizar();
            } else {
                throw new Exception('Access restricted');
            }
        } else {
            throw new Zend_Controller_Request_Exception("Session is required!");
        }
    }

}
